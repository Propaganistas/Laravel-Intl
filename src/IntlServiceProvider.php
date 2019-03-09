<?php namespace Propaganistas\LaravelIntl;

use Illuminate\Foundation\Events\LocaleUpdated;
use Illuminate\Support\ServiceProvider;
use Punic\Data as Punic;

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
        $this->app['events']->listen(LocaleUpdated::class, function ($locale) {
            $this->setLocale();
        });

        $this->setLocale();
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
        require __DIR__.'/Macros/Carbon.php';
    }

    /**
     * Set locales on sub-libraries.
     *
     * @throws \Punic\Exception\InvalidLocale
     */
    protected function setLocale()
    {
        $locale = $this->app['config']['app.locale'];
        $fallbackLocale = $this->app['config']['app.fallback_locale'];

        Punic::setDefaultLocale($locale);
        Punic::setFallbackLocale($fallbackLocale);
    }
}
