<?php
namespace absolutelydigital\LaravelMedoo;

use absolutelydigital\medoo;
use Illuminate\Support\ServiceProvider;

class MedooServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelper();
        $this->app->alias('medoo', 'catfan\medoo');
    }
    /**
     * Register the Goutte instance.
     *
     * @return void
     */
    protected function registerHelper()
    {
        $this->app->singleton('medoo', function ($app) {
            $default = config("database.default");

            $dbConnection = "database.connections." . $default . ".";
            
            $driver = config($dbConnection . "driver");

            if ($driver !== 'sqlite') {
                $options = [
                    'database_type' => $driver,
                    'database_name' => config($dbConnection . "database"),
                    'server' => config($dbConnection . "host"),
                    'username' => config($dbConnection . "username"),
                    'password' => config($dbConnection . "password"),
                    'charset' => config($dbConnection . "charset"),
                ];

                $port = config($dbConnection . "port");

                if (!empty($port)) {
                    $options['port'] = $port;
                }
            } elseif ($driver == 'sqlite') {
                $options = [
                    'database_type' => $driver,
                    'database_file' => config($dbConnection . "database"),
                ];
            }

            $prefix = config($dbConnection . "prefix");

            if (!empty($prefix)) {
                $options['prefix'] = $prefix;
            }

            return new \catfan\medoo($options);
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['medoo'];
    }
}
