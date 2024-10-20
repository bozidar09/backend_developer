<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $locale = app('config')->get('app.faker_locale') ?? 'en_US';

        $abstract = Generator::class . ':' . $locale;

        $this->app->singleton($abstract, function () use ($locale) {
            $faker = Factory::create($locale);

            $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
            $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

            return $faker;
        });
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
