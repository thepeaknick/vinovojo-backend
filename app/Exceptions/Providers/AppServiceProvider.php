<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Database\Eloquent\Relations\Relation;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Wn\Generators\CommandsServiceProvider');
        }

        $this->app->configure('mail');

        $this->app->singleton('mailer', function ($app) {
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
        });

        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
    }

    public function boot() {
        Collection::macro('transliterate', function($languageId, $attributes = []) {

            $collection = $this->toEloquent();

            
            $collection->load(['transliterations' => function ($q) use ($languageId, $attributes) {
                $q->where('language_id', $languageId);
                $q->whereIn('name', $attributes);
            }]);

            $collection->transform(function ($instance) use ($languageId, $attributes) {
                $trans = $instance->transliterate($languageId, $attributes);
                return $trans;
            });

            $collection = $collection->filter( function ($i) { return !is_null($i); } )->values();

            $this->items = $collection->all();

            return $this;

        });

        Collection::macro('toEloquent', function () {
            return ($this instanceof EloquentCollection) ? $this : new EloquentCollection( $this->all() );
        });

        Collection::macro('paginate', function ($perPage = 10, $page = null) {
            if ( is_null($page) ) {
                $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;
            }
            $items = $this->forPage($page, $perPage)->values();
            return new LengthAwarePaginator($items, $this->count(), $perPage, $page);
        });


        Collection::macro('setVisible', function ($attributes = []) {
            $attributes = ( is_array($attributes) ) ? $attributes : func_get_args();
            $this->transform(function ($model) use ($attributes) {
                $model->setVisible($attributes);
                return $model;
            });
        });

        Relation::morphMap([
            app('\App\Wine')->flag => \App\Wine::class,
            app('\App\Winery')->flag => \App\Winery::class
        ]);

        Schema::defaultStringLength(191);

    }
}
