<?php namespace Propaganistas\LaravelIntl\Tests;

use Jenssegers\Date\Date as DateCore;
use Orchestra\Testbench\TestCase;
use Propaganistas\LaravelIntl\Facades\Date;
use Propaganistas\LaravelIntl\IntlServiceProvider;

class TestDate extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp()
    {
        require_once __DIR__.'/../src/helpers.php';

        parent::setUp();
    }

    public function testHelper()
    {
        $this->assertEquals((string) DateCore::now(), (string) carbon('now'));
        $this->assertEquals('Jenssegers\Date\Date', get_class(carbon()));
        $this->assertEquals(DateCore::parse('August 31'), carbon('August 31'));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Date::setLocale('fr');
        $this->assertEquals('fr', carbon()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('31 augustus', Date::parse('August 31')->format('j F'));

        Date::setLocale('en');
        $this->assertEquals('31 August', Date::parse('August 31')->format('j F'));
    }

    public function testFallbackLocaleIsUsed()
    {
        Date::setFallbackLocale('fr');
        Date::setLocale('foo');
        $this->assertEquals('31 août', Date::parse('August 31')->format('j F'));
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $date = Date::usingLocale('en', function($currency) {
            return Date::parse('August 31')->format('j F');
        });

        $this->assertEquals('nl', Date::getLocale());
        $this->assertEquals('31 August', $date);
    }
}
