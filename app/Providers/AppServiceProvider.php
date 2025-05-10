<?php

namespace App\Providers;

use App\Models\Base;
use App\Models\User;
use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
		if (!$this->app->runningInConsole()) {
			auth()->loginUsingId(6);
		}
		$this->registerObservers();
    }


	/**
	 * Register the BaseObserver class on all models
	 *
	 * @return void
	 */
	private function registerObservers() : void {

		// get the path to the models
		$model_path = app_path('Models');

		// get all the models and cycle through them
		$model_files = File::allFiles($model_path);
		foreach ($model_files as $file) {

			// get the namespace of this class
			$relative_path = $file->getRelativePathname(); // e.g., User.php
			$class = 'App\\Models\\' . str_replace(['/', '.php'], ['\\', ''], $relative_path);

			// register the observer
			if (class_exists($class) && is_subclass_of($class, Model::class)) {
				$class::observe(BaseObserver::class);
			}
		}
	}
}
