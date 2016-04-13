<?php namespace Sanatorium\Stock\Repositories\Alias;

use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;

class AliasRepository implements AliasRepositoryInterface {

	use Traits\ContainerTrait, Traits\EventTrait, Traits\RepositoryTrait, Traits\ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Sanatorium\Stock\Handlers\Alias\AliasDataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent stock model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);

		$this->data = $app['sanatorium.stock.alias.handler.data'];

		$this->setValidator($app['sanatorium.stock.alias.validator']);

		$this->setModel(get_class($app['Sanatorium\Stock\Models\Alias']));
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('sanatorium.stock.alias.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('sanatorium.stock.alias.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $input)
	{
		// Create a new alias
		$alias = $this->createModel();

		// Fire the 'sanatorium.stock.alias.creating' event
		if ($this->fireEvent('sanatorium.stock.alias.creating', [ $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForCreation($data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Save the alias
			$alias->fill($data)->save();

			// Fire the 'sanatorium.stock.alias.created' event
			$this->fireEvent('sanatorium.stock.alias.created', [ $alias ]);
		}

		return [ $messages, $alias ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the alias object
		$alias = $this->find($id);

		// Fire the 'sanatorium.stock.alias.updating' event
		if ($this->fireEvent('sanatorium.stock.alias.updating', [ $alias, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($alias, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the alias
			$alias->fill($data)->save();

			// Fire the 'sanatorium.stock.alias.updated' event
			$this->fireEvent('sanatorium.stock.alias.updated', [ $alias ]);
		}

		return [ $messages, $alias ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the alias exists
		if ($alias = $this->find($id))
		{
			// Fire the 'sanatorium.stock.alias.deleted' event
			$this->fireEvent('sanatorium.stock.alias.deleted', [ $alias ]);

			// Delete the alias entry
			$alias->delete();

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => true ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => false ]);
	}

}
