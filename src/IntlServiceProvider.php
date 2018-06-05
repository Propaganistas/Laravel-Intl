<?php namespace Propaganistas\LaravelIntl;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\DateServiceProvider;

class IntlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCountry();
        $this->registerCurrency();
        $this->registerLanguage();
        $this->registerNumber();

        $this->registerDate();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the country repository.
     *
     * @return void
     */
    protected function registerCountry()
    {
        $this->app->singleton(Country::class, function ($app) {
            $repository = new Country;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Country::class, 'intl.country');
    }

    /**
     * Register the currency repository.
     *
     * @return void
     */
    protected function registerCurrency()
    {
        $this->app->singleton(Currency::class, function ($app) {
            $repository = new Currency;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Currency::class, 'intl.currency');
    }

    /**
     * Register the language repository.
     *
     * @return void
     */
    protected function registerLanguage()
    {
        $this->app->singleton(Language::class, function ($app) {
            $repository = new Language;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Language::class, 'intl.language');
    }

    /**
     * Register the number repository.
     *
     * @return void
     */
    protected function registerNumber()
    {
        $this->app->singleton(Number::class, function ($app) {
            $repository = new Number;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Number::class, 'intl.number');
    }

    /**
     * Register the date handler.
     *
     * @return void
     */
    protected function registerDate()
    {
        $this->app->register(DateServiceProvider::class);

        $this->app->singleton(Date::class, function ($app) {
            $repository = new Date;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Date::class, 'intl.date');
    }
}
