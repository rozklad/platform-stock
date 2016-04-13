<?php namespace Sanatorium\Stock\Providers;

use Cartalyst\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Sanatorium\Stock\Models\Alias']
		);

		// Subscribe the registered event handler
		$this->app['events']->subscribe('sanatorium.stock.alias.handler.event');

		// Register the manager
        $this->bindIf('sanatorium.stock.usages', 'Sanatorium\Stock\Repositories\Usages\UsagesRepository');

        // Register the default usage
		$this->app['sanatorium.stock.usages']->registerService(
			'default', $this->app['Sanatorium\Stock\Usages\DefaultUsage']
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('sanatorium.stock.alias', 'Sanatorium\Stock\Repositories\Alias\AliasRepository');

		// Register the data handler
		$this->bindIf('sanatorium.stock.alias.handler.data', 'Sanatorium\Stock\Handlers\Alias\AliasDataHandler');

		// Register the event handler
		$this->bindIf('sanatorium.stock.alias.handler.event', 'Sanatorium\Stock\Handlers\Alias\AliasEventHandler');

		// Register the validator
		$this->bindIf('sanatorium.stock.alias.validator', 'Sanatorium\Stock\Validator\Alias\AliasValidator');
	}

}
