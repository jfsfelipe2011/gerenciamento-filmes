<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Customer;
use App\Film;
use App\Rent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Rent */
    private $rent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rent = new Rent();

        $this->data = [
            'start_date'    => (new \DateTime)->format('Y-m-d'),
            'end_date'      => (new \DateTime)->format('Y-m-d'),
            'delivery_date' => (new \DateTime)->format('Y-m-d'),
            'status'        => $this->faker->randomElement(Rent::VALID_STATUS),
            'value'         => $this->faker->randomFloat(2, 10, 1000),
            'customer_id'   => \rand(1, 100)
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->rent->fill($this->data);

        $this->assertSame($this->data, $this->rent->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeDataDeInicio()
    {
        $this->rent->fill($this->data);

        $this->assertIsString($this->rent->start_date);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeFim()
    {
        $this->rent->fill($this->data);

        $this->assertIsString($this->rent->end_date);
    }

    public function testRetornaUmaStringNaPropriedadeDataDeEntrega()
    {
        $this->rent->fill($this->data);

        $this->assertIsString($this->rent->delivery_date);
    }

    public function testRetornaUmaStringNaPropriedadeStatus()
    {
        $this->rent->fill($this->data);

        $this->assertIsString($this->rent->status);
    }

    public function testRetornaUmFloatNaPropriedadeValue()
    {
        $this->rent->fill($this->data);

        $this->assertIsFloat($this->rent->value);
    }

    public function testRetornaUmIntegerNaPropriedadeClienteId()
    {
        $this->rent->fill($this->data);

        $this->assertIsInt($this->rent->customer_id);
    }

    public function testCustomerRetornaUmCliente()
    {
        $aluguel   = new \ReflectionClass(Rent::class);
        $relations = $aluguel->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->rent, ['customer' => $this->prophesize(Customer::class)->reveal()]);

        $this->assertInstanceOf(Customer::class, $this->rent->customer);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFilmsRetornaUmaColecaoDeFilmes()
    {
        $filmes = $this->getFilmsCollection();

        $aluguel   = new \ReflectionClass(Rent::class);
        $relations = $aluguel->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->rent, ['films' => $filmes]);

        foreach ($this->rent->films as $filme) {
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
    public function testGetStartDateFormattedAttributeRetornaDataEmFormatoBrasileiro()
    {
        $this->rent->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['start_date']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->rent->getStartDateFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testGetEndDateFormattedAttributeRetornaDataEmFormatoBrasileiro()
    {
        $this->rent->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['end_date']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->rent->getEndDateFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testGetDeliveryDateFormattedAttributeRetornaDataEmFormatoBrasileiroSeDefinidoDataDeEntrega()
    {
        $this->rent->fill($this->data);

        $dataFormatada = (new \DateTime($this->data['delivery_date']))->format('d/m/Y');

        $this->assertSame($dataFormatada, $this->rent->getDeliveryDateFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testDeliveryDateFormattedAttributeRetornaUmTracoSeNaoDefinidaDataDeEntrega()
    {
        $this->assertSame('-', $this->rent->getDeliveryDateFormattedAttribute());
    }

    /**
     * @throws \Exception
     */
    public function testDaysOfDelayRetornaInteiroPositivoComADiferencaDoDiaAtualSeAluguelNaoFoiEntregue()
    {
        $endDate = new \DateTime();
        $endDate = $endDate->sub(new \DateInterval('P15D'));

        $this->rent->end_date = $endDate->format('Y-m-d');

        $this->assertIsInt($this->rent->daysOfDelay());
        $this->assertSame(15, $this->rent->daysOfDelay());
    }

    /**
     * @throws \Exception
     */
    public function testDaysOfDelayRetornaInteiroPositivoComADiferencaDoDiaDaEntregaSeAluguelFoiEntregue()
    {
        $deliveryDate = new \DateTimeImmutable();
        $endDate      = $deliveryDate->sub(new \DateInterval('P15D'));

        $this->rent->end_date      = $endDate->format('Y-m-d');
        $this->rent->delivery_date = $deliveryDate->format('Y-m-d');

        $this->assertIsInt($this->rent->daysOfDelay());
        $this->assertSame(15, $this->rent->daysOfDelay());
    }

    public function testDaysOfDelayRetornaZeroSeOAluguelFoiCancelado()
    {
        $this->rent->status = Rent::STATUS_CANCELED;

        $this->assertIsInt($this->rent->daysOfDelay());
        $this->assertSame(0, $this->rent->daysOfDelay());
    }

    /**
     * @throws \Exception
     */
    public function testDaysOfRentRetornaInteiroPositivoComADiferencaEntreInicioEFimEmDias()
    {
        $endDate    = new \DateTimeImmutable();
        $startDate  = $endDate->sub(new \DateInterval('P15D'));

        $this->rent->end_date   = $endDate->format('Y-m-d');
        $this->rent->start_date = $startDate->format('Y-m-d');

        $this->assertIsInt($this->rent->daysOfRent());
        $this->assertSame(15, $this->rent->daysOfRent());
    }

    /**
     * @dataProvider statusProvider
     *
     * @param string $status
     * @param string $expected
     */
    public function testGetStatusFormattedAttributeRetornaStringEmPortuguesParaOStatus(
        string $status,
        string $expected
    ) {
        $this->rent->status = $status;

        $this->assertSame($expected, $this->rent->getStatusFormattedAttribute());
    }

    public function statusProvider()
    {
        return [
            [Rent::STATUS_RENTED, 'Em andamento'],
            [Rent::STATUS_CANCELED, 'Cancelado'],
            [Rent::STATUS_LATE, 'Em atraso'],
            [Rent::STATUS_FINISHED, 'Entregue'],
            ['test', 'Status desconhecido']
        ];
    }
}
