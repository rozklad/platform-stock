<?php namespace Sanatorium\Stock\Handlers\Alias;

use Sanatorium\Stock\Models\Alias;
use Cartalyst\Support\Handlers\EventHandlerInterface as BaseEventHandlerInterface;

interface AliasEventHandlerInterface extends BaseEventHandlerInterface {

	/**
	 * When a alias is being created.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function creating(array $data);

	/**
	 * When a alias is created.
	 *
	 * @param  \Sanatorium\Stock\Models\Alias  $alias
	 * @return mixed
	 */
	public function created(Alias $alias);

	/**
	 * When a alias is being updated.
	 *
	 * @param  \Sanatorium\Stock\Models\Alias  $alias
	 * @param  array  $data
	 * @return mixed
	 */
	public function updating(Alias $alias, array $data);

	/**
	 * When a alias is updated.
	 *
	 * @param  \Sanatorium\Stock\Models\Alias  $alias
	 * @return mixed
	 */
	public function updated(Alias $alias);

	/**
	 * When a alias is deleted.
	 *
	 * @param  \Sanatorium\Stock\Models\Alias  $alias
	 * @return mixed
	 */
	public function deleted(Alias $alias);

}
