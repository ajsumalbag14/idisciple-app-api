<?php

namespace App\Providers;

use Event;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    /**
     * Base directory string value of the bootstrapping
     *
     * @var string
     */
    private $base_directory = 'app/Modules';

    /**
     * Namespace string value of the bootstrapping
     *
     * @var string
     */
    private $base_namespace = 'App\Modules';

    /**
     * Registered modules and services
     *
     * @var array
     */
    private $modules;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->modules = config('module.modules');
        // Bootstrap routing for each service within each modoule
        $this->loadModuleServiceRoutes();
        // Bootstrap views for each service within each module
        $this->loadModuleServiceView();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Load module service routes
     *
     * @return void
     */
    public function loadModuleServiceRoutes()
    {
        $this->base_directory = base_path($this->base_directory);
        // Load each module and services
        foreach ($this->modules as $module => $services) {
            // Load each service
            foreach ($services as $service) {
                // Load the routes for each of the service
                if(file_exists($this->base_directory.'/'.$module.'/'.$service.'/routes.php')) {
                    include $this->base_directory.'/'.$module.'/'.$service.'/routes.php';
                }
            }
        }
    }

    /**
     * Load module service views
     *
     * @return void
     */
    public function loadModuleServiceView()
    {
        $this->base_directory = base_path($this->base_directory);
        // Load each module and services
        foreach ($this->modules as $module => $services) {
            // Load each service
            foreach ($services as $service) {
                // Load the view for each of the service
                if(is_dir($this->base_directory.'/'.$module.'/'.$service.'/Views')) {
                    $this->loadViewsFrom($this->base_directory.'/'.$module.'/'.$service.'/Views', $service);
                }
            }
        }
    }

}
