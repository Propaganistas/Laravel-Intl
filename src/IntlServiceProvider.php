<?php namespace Propaganistas\LaravelIntl;

use Carbon\Carbon;
use CommerceGuys\Intl\Country\CountryRepository;
use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\Language\LanguageRepository;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
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
        $this->registerCountryRepository();
        $this->registerCurrencyRepository();
        $this->registerLanguageRepository();
        $this->registerNumberRepository();

        $this->registerDateHandler();
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
    protected function registerCountryRepository()
    {
        $this->app->singleton(CountryRepository::class, function ($app) {
            $repository = new CountryRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias(Country::class, 'intl.country');
    }

    /**
     * Register the currency repository.
     *
     * @return void
     */
    protected function registerCurrencyRepository()
    {
        $this->app->singleton(CurrencyRepository::class, function ($app) {
            $repository = new CurrencyRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias(Currency::class, 'intl.currency');
    }

    /**
     * Register the language repository.
     *
     * @return void
     */
    protected function registerLanguageRepository()
    {
        $this->app->singleton(LanguageRepository::class, function ($app) {
            $repository = new LanguageRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias(Language::class, 'intl.language');
    }

    /**
     * Register the number repository.
     *
     * @return void
     */
    protected function registerNumberRepository()
    {
        $this->app->singleton(NumberFormatRepository::class, function ($app) {
            $repository = new NumberFormatRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias(Number::class, 'intl.number');
    }

    /**
     * Register the date handler.
     *
     * @return void
     */
    protected function registerDateHandler()
    {
        $this->app->register(DateServiceProvider::class);

        \Jenssegers\Date\Date::setFallbackLocale($app['config']['app.fallback_locale']);

        $this->app->singleton(Carbon::class, function () {
            return new Date;
        });

        $this->app->alias(Carbon::class, 'intl.date');
    }
}