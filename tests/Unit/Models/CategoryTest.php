<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Category;
use App\Film;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Category */
    private $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = new Category();

        $this->data = [
            'name'        => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->category->fill($this->data);

        $this->assertSame($this->data, $this->category->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeNome()
    {
        $this->category->fill($this->data);

        $this->assertIsString($this->category->name);
    }

    public function testRetornaUmaStringNaPropriedadeDescricao()
    {
        $this->category->fill($this->data);

        $this->assertIsString($this->category->description);
    }

    public function testFilmsRetornaUmaColecaoDeFilmes()
    {
        $filmes = $this->getFilmsCollection();

        $category  = new \ReflectionClass(Category::class);
        $relations = $category->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->category, ['films' => $filmes]);

        foreach ($this->category->films as $filme) {
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
}
