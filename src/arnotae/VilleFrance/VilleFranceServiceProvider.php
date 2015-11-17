<?php namespace arnotae\VilleFrance;

use Illuminate\Support\ServiceProvider;

class VilleFranceServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	protected $vendor  = 'arnotae';

	protected $package = 'ville-france';
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->register();

		$this->publishes([
			__DIR__.'/../../migrations/' => database_path('migrations')
		], 'migrations');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['command.ville.load'] = $this->app->share(function($app)
		{
			return new \arnotae\VilleFrance\Command\LoadData;
		});
		$this->commands('command.ville.load');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
