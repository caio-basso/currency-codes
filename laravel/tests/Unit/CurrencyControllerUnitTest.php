<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class CurrencyControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    private $mockedCurrencyService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockedCurrencyService = $this->mock(CurrencyService::class);
    }

    public function testGetCurrencyShouldPassWithValidRequest()
    {
        $requestData = ['list' => ['USD', '002']];
        $filteredData = ['USD' => ['code' => 'USD', 'number' => '001'], 'EUR' => ['code' => 'EUR', 'number' => '002']];

        $this->mockedCurrencyService
            ->shouldReceive('getCurrency')
            ->once()
            ->with($requestData)
            ->andReturn($filteredData);

        $response = $this->json('POST', '/api/currency', $requestData);

        $response->assertStatus(200);
    }

    public function testGetCurrencyShouldThrowErrorWhenArrayValueSizeDifferentFromThree()
    {
        $requestData = ['list' => ['USD', '2']];

        $response = $this->json('POST', '/api/currency', $requestData);

        $response->assertStatus(422);
    }

    public function testGetCurrencyShouldThrowNotFoundExceptionWhenCurrencyDoesNotExist()
    {
        $requestData = ['list' => ['XYZ', '123']];

        $this->mockedCurrencyService
            ->shouldReceive('getCurrency')
            ->once()
            ->with($requestData)
            ->andThrow(new NotFoundHttpException);

        $response = $this->json('POST', '/api/currency', $requestData);

        $response->assertStatus(404);
    }
}
