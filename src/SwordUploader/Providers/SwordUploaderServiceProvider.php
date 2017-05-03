<?php

namespace CSUNMetaLab\SwordUploader\Providers;

use Illuminate\Support\ServiceProvider;

class SwordServiceProvider extends ServiceProvider
{
	public function boot() {
		$this->publishes([
        	__DIR__.'/../config/sword.php' => config_path('sword.php'),
    	]);
	}
}