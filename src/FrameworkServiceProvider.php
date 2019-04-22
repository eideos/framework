<?php

namespace Eideos\Framework;

use Illuminate\Support\ServiceProvider;

class FrameworkServiceProvider extends ServiceProvider {

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishAssets();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->loadViewsFrom(__DIR__ . '/views', 'framework');
    }

    protected function publishAssets() {
        $this->publishes([realpath(__DIR__ . '/../public') => public_path('/vendor/framework'),], 'public');
  }

}
