<?php

namespace Papposilene\Geodata\Tests;

use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Exceptions\CityDoesNotExist;

class CityTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_when_a_city_does_not_exist()
    {
        $this->expectException(CityDoesNotExist::class);

        app(City::class)->findByName('not a city');
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $city_by_id = app(City::class)->findById($this->testCity->id);

        $this->assertEquals($this->testCity->id, $city_by_id->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $city_by_name = app(City::class)->findByName($this->testCity->name);

        $this->assertEquals($this->testCity->name, $city_by_name->name);
    }

    /** @test */
    public function it_is_retrievable_by_state()
    {
        $city_by_state = app(City::class)->findByState($this->testCity->name, $this->testCity->state);

        $this->assertEquals($this->testCity->name, $city_by_state->name);
    }

    /** @test */
    public function it_is_retrievable_by_postcodes()
    {
        $city_by_postcodes = app(City::class)->findByPostcodes($this->testCity->postcodes);

        $this->assertEquals($this->testCity->postcodes, $city_by_postcodes->name);
    }
}
