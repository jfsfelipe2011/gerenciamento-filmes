<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Director;
use App\Film;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DirectorTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Director */
    private $director;

    protected function setUp(): void
    {
        parent::setUp();

        $this->director = new Director();

        $this->data = [
            'name'          => $this->faker->firstName . ' ' . $this->faker->lastName,
            'date_of_birth' => (new \DateTime)->format('Y-m-d'),
            'date_of_death' => (new \DateTime)->format('Y-m-d'),
            'oscar'         => $this->faker->randomNumber(1),
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->director->fill($this->data);

        $this->assertSame($this->data, $this->director->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeNome()
    {
        $this->director->fill($this->data);

        $this->assertIsString($this->director->name);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeNascimento()
    {
        $this->director->fill($this->data);

        $this->assertIsString($this->director->date_of_birth);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeFalescimento()
    {
        $this->director->fill($this->data);

        $this->assertIsString($this->director->date_of_death);
    }

    public function testRetornaUmIntegerNaPropriedadeOscar()
    {
        $this->director->fill($this->data);

        $this->assertIsInt($this->director->oscar);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFilmsRetornaUmaColecaoDeFilmes()
    {
        $filmes = $this->getFilmsCollection();

        $director  = new \ReflectionClass(Director::class);
        $relations = $director->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->director, ['films' => $filmes]);

        foreach ($this->director->films as $filme) {
            $this->assertInstanceOf(Film::class, $filme);
        }
    }

    public function getFilmsCollection()
    {
        $numero     = \rand(1, 10);
        $collection = new Collection();

        for ($i = 0; $i < $numero; $i++) {
            $collection->add($this->prophesize(Film::class)->reveal());
        }

        return $collection;
    }

    /**
     * @throws \Exception
     */
    public function testGetDateOfBirthFormattedAttributeRetornaDataEmFormatoBrasileiro()
    {
        $this->director->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['date_of_birth']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->director->getDateOfBirthFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testgetDateOfDeathFormattedAttributeRetornaDataEmFormatoBrasileiroSeForDefinidaDataDeFalescimento()
    {
        $this->director->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['date_of_death']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->director->getDateOfDeathFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testDateOfDeathFormattedAttributeRetornaUmTracoSeNaoDefinidaDataDeFalescimento()
    {
        $this->assertSame('-', $this->director->getDateOfDeathFormattedAttribute());
    }
}
