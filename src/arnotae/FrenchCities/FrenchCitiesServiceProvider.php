<?php namespace arnotae\FrenchCities;

use Illuminate\Support\ServiceProvider;

class FrenchCitiesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	protected $vendor  = 'arnotae';

	protected $package = 'frenchcities';
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
		$this->app['command.city.load'] = $this->app->share(function($app)
		{
			return new \arnotae\FrenchCities\Command\LoadData;
		});
		$this->commands('command.city.load');
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
