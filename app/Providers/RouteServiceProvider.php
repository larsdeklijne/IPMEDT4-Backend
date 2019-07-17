<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => ['api', 'cors'],
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            //Add you routes here, for example:
            // /api/complaints
            Route::post('/complaints/store/{train_name}/{name}/{email}/{complaint}', 'ComplaintsController@store');
            Route::get('/complaints/{complaint}', "ComplaintsController@show")->where('complaint', '\d+');
            Route::get('/complaints/index', 'ComplaintsController@index');
            Route::post('/user/register/{name}/{email}/{password}', 'UserController@register');
            Route::get('/user/login/{email}/{password}', 'UserController@login');
            Route::get('profile', 'UserController@getAuthenticatedUser');
            Route::post('/complaints/status/toggle/{id}/{toggle_value}', 'ComplaintsController@toggle');
        });
    }
}
