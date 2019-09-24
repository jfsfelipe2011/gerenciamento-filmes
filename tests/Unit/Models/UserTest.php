<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use WithFaker;

    /** @var array */
    private $data;

    /** @var User */
    private $user;

    /** @var Carbon */
    private $carbon;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User;

        $this->data = [
            'name'           => $this->faker->firstName . ' ' . $this->faker->lastName,
            'email'          => $this->faker->email,
            'password'       => \bcrypt($this->faker->word)
        ];

        $this->carbon = $this->prophesize(Carbon::class);
        $this->carbon->settings()->willReturn(['value']);
        $this->carbon->format('Y-m-d H:i:s.u')->willReturn(\date('Y-m-d H:i:s.u'));
        $this->carbon->getTimezone()->willReturn('Europe/London');
        $this->carbon->getSettings()->willReturn(['value']);
    }
    
    public function testPreencheCamposQueSaoFillables()
    {
        $this->user->fill($this->data);

        $this->assertSame($this->data['password'], $this->user->password);

        unset($this->data['password']);

        $this->assertSame($this->data, $this->user->toArray());
    }

    public function testNaoRetornaNoArrayCamposQueSaoHidden()
    {
        $this->user->fill($this->data);

        $this->assertNotSame($this->data, $this->user->toArray());
    }

    public function testRetornaUmaStringNaPropriedadeNome()
    {
        $this->user->fill($this->data);

        $this->assertIsString($this->user->name);
    }

    public function testRetornaUmaStringNaPropriedadeEmail()
    {
        $this->user->fill($this->data);

        $this->assertIsString($this->user->email);
    }

    public function testRetornaUmaStringNaPropriedadePassword()
    {
        $this->user->fill($this->data);

        $this->assertIsString($this->user->password);
    }

    public function testRetornaUmaStringNaPropriedadeRememberToken()
    {
        $this->user->remember_token = \bcrypt($this->faker->word);

        $this->assertIsString($this->user->remember_token);
    }

    public function testRetornaUmaObjetoCarbonNaPropriedadeEmailVerifiedAt()
    {
        $this->user->email_verified_at = $this->carbon->reveal();

        $this->assertInstanceOf(Carbon::class, $this->user->email_verified_at);
    }
}
