<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Film;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Actor;

class ActorTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Actor */
    private $actor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actor = new Actor();

        $this->data = [
            'name'          => $this->faker->firstName . ' ' . $this->faker->lastName,
            'date_of_birth' => (new \DateTime)->format('Y-m-d'),
            'date_of_death' => (new \DateTime)->format('Y-m-d'),
            'oscar'         => $this->faker->randomNumber(1),
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->actor->fill($this->data);

        $this->assertSame($this->data, $this->actor->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeNome()
    {
        $this->actor->fill($this->data);

        $this->assertIsString($this->actor->name);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeNascimento()
    {
        $this->actor->fill($this->data);

        $this->assertIsString($this->actor->date_of_birth);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeFalescimento()
    {
        $this->actor->fill($this->data);

        $this->assertIsString($this->actor->date_of_death);
    }

    public function testRetornaUmIntegerNaPropriedadeOscar()
    {
        $this->actor->fill($this->data);

        $this->assertIsInt($this->actor->oscar);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFilmsRetornaUmaColecaoDeFilmes()
    {
        $filmes = $this->getFilmsCollection();

        $actor     = new \ReflectionClass(Actor::class);
        $relations = $actor->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->actor, ['films' => $filmes]);

        foreach ($this->actor->films as $filme) {
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
        $this->actor->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['date_of_birth']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->actor->getDateOfBirthFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testgetDateOfDeathFormattedAttributeRetornaDataEmFormatoBrasileiroSeForDefinidaDataDeFalescimento()
    {
        $this->actor->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['date_of_death']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->actor->getDateOfDeathFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testDateOfDeathFormattedAttributeRetornaUmTracoSeNaoDefinidaDataDeFalescimento()
    {
        $this->assertSame('-', $this->actor->getDateOfDeathFormattedAttribute());
    }
}
