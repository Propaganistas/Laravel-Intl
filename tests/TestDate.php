<?php namespace Propaganistas\LaravelIntl\Tests;

use Illuminate\Support\Facades\Date;
use Orchestra\Testbench\TestCase;
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

    public function setUp(): void
    {
        require_once __DIR__.'/../src/helpers.php';

        parent::setUp();
    }

    public function testHelper()
    {
        $this->assertEquals((string) Date::now(), (string) carbon('now'));
        $this->assertEquals(Date::parse('August 31'), carbon('August 31'));
    }

    public function testToShortDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toShortDateString();

        $this->assertEquals('31-01-2018', $date);
    }

    public function testToMediumDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toMediumDateString();

        $this->assertEquals('31 jan. 2018', $date);
    }

    public function testToLongDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toLongDateString();

        $this->assertEquals('31 januari 2018', $date);
    }

    public function testToFullDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toFullDateString();

        $this->assertEquals('woensdag 31 januari 2018', $date);
    }

    public function testToShortTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toShortTimeString();

        $this->assertEquals('01:02', $date);
    }

    public function testToMediumTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toMediumTimeString();

        $this->assertEquals('01:02:03', $date);
    }

    public function testToLongTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toLongTimeString();

        $this->assertEquals('01:02:03 UTC', $date);
    }

    public function testToFullTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,1,1,2,3)->toFullTimeString();

        $this->assertEquals('01:02:03 Gecoördineerde wereldtijd', $date);
    }

    public function testToShortDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toShortDatetimeString();

        $this->assertEquals('31-01-2018 01:02', $date);
    }

    public function testToMediumDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toMediumDatetimeString();

        $this->assertEquals('31 jan. 2018 01:02:03', $date);
    }

    public function testToLongDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toLongDatetimeString();

        $this->assertEquals('31 januari 2018 om 01:02:03 UTC', $date);
    }

    public function testToFullDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toFullDatetimeString();

        $this->assertEquals('woensdag 31 januari 2018 om 01:02:03 Gecoördineerde wereldtijd', $date);
    }
}
