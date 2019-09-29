<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Film;
use App\Stock;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Stock */
    private $stock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stock = new Stock();

        $this->data = [
            'value'    => $this->faker->randomFloat(2, 5, 1000),
            'quantity' => $this->faker->randomNumber(3),
            'film_id'  => $this->faker->randomNumber(1)
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->stock->fill($this->data);

        $this->assertSame($this->data, $this->stock->toArray());
    }

    public function testRetornaUmFloatNaPropriedadeValor()
    {
        $this->stock->fill($this->data);

        $this->assertIsFloat($this->stock->value);
    }

    public function testRetornaUmIntegerNaPropriedadeQuantidade()
    {
        $this->stock->fill($this->data);

        $this->assertIsInt($this->stock->quantity);
    }

    public function testRetornaUmIntegerNaPropriedadeFilmeId()
    {
        $this->stock->fill($this->data);

        $this->assertIsInt($this->stock->film_id);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFilmRetornaUmaObjetoFilme()
    {
        $stock     = new \ReflectionClass(Stock::class);
        $relations = $stock->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->stock, ['film' => $this->prophesize(Film::class)->reveal()]);

        $this->assertInstanceOf(Film::class, $this->stock->film);
    }
}
