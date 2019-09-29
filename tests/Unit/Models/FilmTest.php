<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Actor;
use App\Category;
use App\Director;
use App\Film;
use App\Rent;
use App\Stock;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Film */
    private $film;

    protected function setUp(): void
    {
        parent::setUp();

        $this->film = new Film();

        $this->data = [
            'name'         => $this->faker->words(3, true),
            'description'  => $this->faker->sentence,
            'image'        => $this->faker->sha256,
            'duration'     => $this->faker->randomNumber(3),
            'release_date' => (new \DateTime)->format('Y-m-d'),
            'category_id'  => $this->faker->randomNumber(1)
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->film->fill($this->data);

        $this->assertSame($this->data, $this->film->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeNome()
    {
        $this->film->fill($this->data);

        $this->assertIsString($this->film->name);
    }

    public function testRetornaUmaStringNaPropriedadeDescricao()
    {
        $this->film->fill($this->data);

        $this->assertIsString($this->film->description);
    }

    public function testRetornaUmaStringNaPropriedadeImagem()
    {
        $this->film->fill($this->data);

        $this->assertIsString($this->film->image);
    }

    public function testRetornaUmIntegerNaPropriedadeDuration()
    {
        $this->film->fill($this->data);

        $this->assertIsInt($this->film->duration);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeLancamento()
    {
        $this->film->fill($this->data);

        $this->assertIsString($this->film->release_date);
    }

    public function testRetornaUmIntegerNaPropriedadeCategoriaId()
    {
        $this->film->fill($this->data);

        $this->assertIsInt($this->film->category_id);
    }

    /**
     * @throws \ReflectionException
     */
    public function testCategoryRetornaObjetoCategory()
    {
        $film      = new \ReflectionClass(Film::class);
        $relations = $film->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->film, ['category' => $this->prophesize(Category::class)->reveal()]);

        $this->assertInstanceOf(Category::class, $this->film->category);
    }

    /**
     * @throws \ReflectionException
     */
    public function testDirectorsRetornaUmaColecaoDeDiretores()
    {
        $diretores = $this->getDirectorsCollection();

        $film     = new \ReflectionClass(Film::class);
        $relations = $film->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->film, ['directors' => $diretores]);

        foreach ($this->film->directors as $director) {
            $this->assertInstanceOf(Director::class, $director);
        }
    }

    public function getDirectorsCollection()
    {
        $numero     = \rand(1, 10);
        $collection = new Collection();

        for ($i = 0; $i < $numero; $i++) {
            $collection->add($this->prophesize(Director::class)->reveal());
        }

        return $collection;
    }

    /**
     * @throws \ReflectionException
     */
    public function testActorsRetornaUmaColecaoDeAtores()
    {
        $actors = $this->getActorsCollection();

        $film      = new \ReflectionClass(Film::class);
        $relations = $film->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->film, ['actors' => $actors]);

        foreach ($this->film->actors as $actor) {
            $this->assertInstanceOf(Actor::class, $actor);
        }
    }

    public function getActorsCollection()
    {
        $numero     = \rand(1, 10);
        $collection = new Collection();

        for ($i = 0; $i < $numero; $i++) {
            $collection->add($this->prophesize(Actor::class)->reveal());
        }

        return $collection;
    }

    /**
     * @throws \ReflectionException
     */
    public function testStockRetornaObjetoStock()
    {
        $film      = new \ReflectionClass(Film::class);
        $relations = $film->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->film, ['stock' => $this->prophesize(Stock::class)->reveal()]);

        $this->assertInstanceOf(Stock::class, $this->film->stock);
    }

    /**
     * @throws \ReflectionException
     */
    public function testRentsRetornaUmaColecaoDeRents()
    {
        $rents = $this->getRentsCollection();

        $film      = new \ReflectionClass(Film::class);
        $relations = $film->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->film, ['rents' => $rents]);

        foreach ($this->film->rents as $rent) {
            $this->assertInstanceOf(Rent::class, $rent);
        }
    }

    public function getRentsCollection()
    {
        $numero     = \rand(1, 10);
        $collection = new Collection();

        for ($i = 0; $i < $numero; $i++) {
            $collection->add($this->prophesize(Rent::class)->reveal());
        }

        return $collection;
    }

    /**
     * @throws \Exception
     */
    public function testGetReleaseDateFormattedAttributeRetornaDataEmFormatoBrasileiro()
    {
        $this->film->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['release_date']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->film->getReleaseDateFormattedAttribute());
    }
}
