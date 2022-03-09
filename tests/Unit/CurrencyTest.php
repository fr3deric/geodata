<?php

namespace Papposilene\Geodata\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Papposilene\Geodata\Contracts\Currency;
use Papposilene\Geodata\Exceptions\CurrencyDoesNotExist;

class CurrencyTest extends TestCase
{
    //use DatabaseMigrations;

    /** @test */
    public function it_throws_an_exception_when_a_currency_does_not_exist()
    {
        $this->expectException(CurrencyDoesNotExist::class);

        app(Currency::class)->where('name', 'not a currency')->isEmpty();
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $currency_by_id = app(Currency::class)->findById($this->testCurrency->id);

        $this->assertEquals($this->testCurrency->id, $currency_by_id->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $currency_by_name = app(Currency::class)->findByName($this->testCurrency->name);

        $this->assertEquals($this->testCurrency->name, $currency_by_name->name);
    }
}