<?php namespace Sanatorium\Stock\Handlers\Alias;

use Illuminate\Events\Dispatcher;
use Sanatorium\Stock\Models\Alias;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class AliasEventHandler extends BaseEventHandler implements AliasEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('sanatorium.stock.alias.creating', __CLASS__.'@creating');
		$dispatcher->listen('sanatorium.stock.alias.created', __CLASS__.'@created');

		$dispatcher->listen('sanatorium.stock.alias.updating', __CLASS__.'@updating');
		$dispatcher->listen('sanatorium.stock.alias.updated', __CLASS__.'@updated');

		$dispatcher->listen('sanatorium.stock.alias.deleted', __CLASS__.'@deleted');
	}

	/**
	 * {@inheritDoc}
	 */
	public function creating(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function created(Alias $alias)
	{
		$this->flushCache($alias);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Alias $alias, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Alias $alias)
	{
		$this->flushCache($alias);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Alias $alias)
	{
		$this->flushCache($alias);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Sanatorium\Stock\Models\Alias  $alias
	 * @return void
	 */
	protected function flushCache(Alias $alias)
	{
		$this->app['cache']->forget('sanatorium.stock.alias.all');

		$this->app['cache']->forget('sanatorium.stock.alias.'.$alias->id);
	}

}
