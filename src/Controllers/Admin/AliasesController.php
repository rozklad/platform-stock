<?php namespace Sanatorium\Stock\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Sanatorium\Stock\Repositories\Alias\AliasRepositoryInterface;
use Sanatorium\Stock\Repositories\Usages\UsagesRepositoryInterface;

class AliasesController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Stock repository.
	 *
	 * @var \Sanatorium\Stock\Repositories\Alias\AliasRepositoryInterface
	 */
	protected $aliases;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

	/**
	 * Constructor.
	 *
	 * @param  \Sanatorium\Stock\Repositories\Alias\AliasRepositoryInterface  	$aliases
	 * @param  \Sanatorium\Stock\Repositories\Usages\UsagesRepositoryInterface  $usages
	 * @return void
	 */
	public function __construct(AliasRepositoryInterface $aliases,
		UsagesRepositoryInterface $usages)
	{
		parent::__construct();

		$this->usages = $usages;

		$this->aliases = $aliases;
	}

	/**
	 * Display a listing of alias.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/stock::aliases.index');
	}

	/**
	 * Datasource for the alias Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->aliases->grid();

		$columns = [
			'id',
			'usage',
			'min',
			'max',
			'alias',
			'product_id',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$usages = $this->usages->getServices();

		$transformer = function($element) use ($usages)
		{
			$element->edit_uri = route('admin.sanatorium.stock.aliases.edit', $element->id);

			$element->usage_name = (new $usages[$element->usage])->name;

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
	}

	/**
	 * Show the form for creating new alias.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new alias.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating alias.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating alias.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified alias.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->aliases->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("sanatorium/stock::aliases/message.{$type}.delete")
		);

		return redirect()->route('admin.sanatorium.stock.aliases.all');
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = request()->input('action');

		if (in_array($action, $this->actions))
		{
			foreach (request()->input('rows', []) as $row)
			{
				$this->aliases->{$action}($row);
			}

			return response('Success');
		}

		return response('Failed', 500);
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a alias identifier?
		if (isset($id))
		{
			if ( ! $alias = $this->aliases->find($id))
			{
				$this->alerts->error(trans('sanatorium/stock::aliases/message.not_found', compact('id')));

				return redirect()->route('admin.sanatorium.stock.aliases.all');
			}
		}
		else
		{
			$alias = $this->aliases->createModel();
		}

		$usages = $this->usages->getServices();

		// Show the page
		return view('sanatorium/stock::aliases.form', compact('mode', 'alias', 'usages'));
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Store the alias
		list($messages) = $this->aliases->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("sanatorium/stock::aliases/message.success.{$mode}"));

			return redirect()->route('admin.sanatorium.stock.aliases.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

}
