<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Customer;
use App\Rent;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CustomerTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var Customer */
    private $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = new Customer();

        $this->data = [
            'name'     => $this->faker->firstName . ' ' . $this->faker->lastName,
            'address'  => $this->faker->address,
            'document' => '02419587090',
            'payment'  => $this->faker->randomElement(Customer::VALID_PAYMENTS)
        ];
    }

    public function testPreencheCamposQueSaoFillables()
    {
        $this->customer->fill($this->data);

        $this->assertSame($this->data, $this->customer->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeNome()
    {
        $this->customer->fill($this->data);

        $this->assertIsString($this->customer->name);
    }

    public function testRetornaUmaStringNaPropriedadeEndereco()
    {
        $this->customer->fill($this->data);

        $this->assertIsString($this->customer->address);
    }

    public function testRetornaUmaStringNaPropriedadeDocumento()
    {
        $this->customer->fill($this->data);

        $this->assertIsString($this->customer->document);
    }

    public function testRetornaUmaStringNaPropriedadePagamento()
    {
        $this->customer->fill($this->data);

        $this->assertIsString($this->customer->payment);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFilmsRetornaUmaColecaoDeFilmes()
    {
        $alugueis  = $this->getRentsCollection();

        $customer  = new \ReflectionClass(Customer::class);
        $relations = $customer->getProperty('relations');
        $relations->setAccessible(true);
        $relations->setValue($this->customer, ['rents' => $alugueis]);

        foreach ($this->customer->rents as $aluguel) {
            $this->assertInstanceOf(Rent::class, $aluguel);
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

    public function testGetDocumentFormattedAttributeRetornaDocumentoComPontuacao()
    {
        $this->customer->fill($this->data);

        $documentoFormatado = preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            $this->data['document']
        );

        $this->assertSame($documentoFormatado, $this->customer->getDocumentFormattedAttribute());
    }

    /**
     * @dataProvider paymentProvider
     *
     * @param string $payment
     * @param string $expected
     */
    public function testGetPaymentFormattedAttributeRetornaPagamentoComoUmStringEmPortugues(
        string $payment,
        string $expected
    ) {
        $this->customer->payment = $payment;

        $this->assertSame($expected, $this->customer->getPaymentFormattedAttribute());
    }

    public function paymentProvider()
    {
        return [
            [Customer::BILLET, 'Boleto'],
            [Customer::CREDIT_CARD, 'Cartão de Crédito']
        ];
    }
}
