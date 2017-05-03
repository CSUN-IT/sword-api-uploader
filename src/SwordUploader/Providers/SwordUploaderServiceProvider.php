<?php

namespace CSUNMetaLab\SwordUploader\Providers;

use CSUNMetaLab\SwordUploader\Uploaders\SwordUploader;
use Illuminate\Support\ServiceProvider;

class SwordServiceProvider extends ServiceProvider
{
	public function register() {
		// register the uploader as a singleton
		$this->app->singleton('sword', function($app) {
			return new SwordUploader(
				config('sword.service_document'),
				config('sword.deposit'),
				config('sword.username'),
				config('sword.password')
			);
		});

		// register the facade for the uploader
		$this->app->alias('sword', SwordUploader::class);
	}

	public function boot() {
		$this->publishes([
        	__DIR__.'/../config/sword.php' => config_path('sword.php'),
    	]);
	}
}