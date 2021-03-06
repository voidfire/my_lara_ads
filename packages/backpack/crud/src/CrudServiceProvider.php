<?php

namespace Larapen\CRUD;

use Illuminate\Support\ServiceProvider;
use Route;

class CrudServiceProvider extends \Backpack\CRUD\CrudServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CRUD', function ($app) {
            return new CRUD($app);
        });

        // register its dependencies
        $this->app->register(\Larapen\Base\BaseServiceProvider::class);
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        $this->app->register(\Barryvdh\Elfinder\ElfinderServiceProvider::class);

        // register their aliases
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('CRUD', \Larapen\CRUD\CrudServiceProvider::class);
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
    }

    public static function resource($name, $controller, array $options = [])
    {
        // CRUD routes
        Route::post($name.'/search', ['as' => 'crud.'.$name.'.search', 'uses' => $controller.'@search',]);
        Route::get($name.'/reorder', ['as' => 'crud.'.$name.'.reorder', 'uses' => $controller.'@reorder',]);
		Route::get($name.'/reorder/{lang}', ['as' => 'crud.'.$name.'.reorder', 'uses' => $controller.'@reorder',]);
        Route::post($name.'/reorder', ['as' => 'crud.'.$name.'.save.reorder', 'uses' => $controller.'@saveReorder',]);
		Route::post($name.'/reorder/{lang}', ['as' => 'crud.'.$name.'.save.reorder', 'uses' => $controller.'@saveReorder',]);
        Route::get($name.'/{id}/details', ['as' => 'crud.'.$name.'.showDetailsRow', 'uses' => $controller.'@showDetailsRow',]);
        Route::get($name.'/{id}/translate/{lang}', ['as' => 'crud.'.$name.'.translateItem', 'uses' => $controller.'@translateItem',]);

        $options_with_default_route_names = array_merge([
            'names' => [
                'index'     => 'crud.'.$name.'.index',
                'create'    => 'crud.'.$name.'.create',
                'store'     => 'crud.'.$name.'.store',
                'edit'      => 'crud.'.$name.'.edit',
                'update'    => 'crud.'.$name.'.update',
                'show'      => 'crud.'.$name.'.show',
                'destroy'   => 'crud.'.$name.'.destroy',
                ],
            ], $options);

        Route::resource($name, $controller, $options_with_default_route_names);
    }
}
