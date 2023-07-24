<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Cache;
use App\Integrator\PythonIntegrator;
use App\Services\CurrencyService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tests\TestCase;

class CurrencyServiceUnitTest extends TestCase
{
    private $mockedPythonIntegrator;
    private $crawlerData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockedPythonIntegrator = $this->createMock(PythonIntegrator::class);

        $this->crawlerData = [
            ["code" => "AED", "number"=> "784", "decimal"=> "2", "currency"=> "Dirham dos Emirados", "currency_locations" => ["location" => "Emirados \u00c1rabes Unidos", "icon"=> "//upload.wikimedia.org/wikipedia/commons/thumb/c/cb/Flag_of_the_United_Arab_Emirates.svg/22px-Flag_of_the_United_Arab_Emirates.svg.png"]],
            ["code"=> "AFN", "number"=> "784", "decimal"=> "2", "currency"=> "Afegane", "currency_locations"=> ["location"=> "Afeganist\u00e3o", "icon"=> "//upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Flag_of_the_Taliban.svg/22px-Flag_of_the_Taliban.svg.png"]],
        ];
    }

    /**
     * @throws Throwable
     */
    public function testGetCurrencyShouldThrowNotFoundExceptionWhenReceiveEmptyListAndDataIsCached()
    {
        Cache::shouldReceive('has')->once()->andReturn(true);
        Cache::shouldReceive('get')->once()->andReturn($this->crawlerData);

        $currencyService = new CurrencyService($this->mockedPythonIntegrator);

        $requestData = ['list' => []];

        $this->expectException(NotFoundHttpException::class);
        $currencyService->getCurrency($requestData);
    }

    /**
     * @throws Throwable
     */
    public function testGetCurrencyShouldPassWhenCurrencyExistsAndDataIsCached()
    {
        Cache::shouldReceive('has')->once()->andReturn(true);
        Cache::shouldReceive('get')->once()->andReturn($this->crawlerData);

        $currencyService = new CurrencyService($this->mockedPythonIntegrator);

        $requestData = ['list' => ['AFN', '784']];
        $result = $currencyService->getCurrency($requestData);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    /**
     * @throws Throwable
     */
    public function testGetCurrencyShouldThrowNotFoundExceptionWhenCurrencyDoesNotExistAndDataIsCached()
    {
        Cache::shouldReceive('has')->once()->andReturn(true);
        Cache::shouldReceive('get')->once()->andReturn($this->crawlerData);

        $currencyService = new CurrencyService($this->mockedPythonIntegrator);

        $requestData = ['list' => ['XYZ', '123']];

        $this->expectException(NotFoundHttpException::class);
        $currencyService->getCurrency($requestData);
    }

    /**
     * @throws Throwable
     */
    public function testGetCurrencyShouldThrowNotFoundExceptionWhenReceiveEmptyListAndDataIsNotCached()
    {
        Cache::shouldReceive('has')->once()->andReturn(false);
        $this->mockedPythonIntegrator
            ->expects($this->once())
            ->method('runCrawler')
            ->willReturn($this->crawlerData);
        Cache::shouldReceive('put')->once();
        Cache::shouldReceive('get')->once()->andReturn($this->crawlerData);

        $currencyService = new CurrencyService($this->mockedPythonIntegrator);

        $requestData = ['list' => []];

        $this->expectException(NotFoundHttpException::class);
        $currencyService->getCurrency($requestData);
    }

    /**
     * @throws Throwable
     */
    public function testGetCurrencyShouldPassWhenCurrencyExistsAndDataIsNotCached()
    {
        Cache::shouldReceive('has')->once()->andReturn(false);
        $this->mockedPythonIntegrator
            ->expects($this->once())
            ->method('runCrawler')
            ->willReturn($this->crawlerData);
        Cache::shouldReceive('put')->once();
        Cache::shouldReceive('get')->once()->andReturn($this->crawlerData);

        $currencyService = new CurrencyService($this->mockedPythonIntegrator);

        $requestData = ['list' => ['AFN', '784']];
        $result = $currencyService->getCurrency($requestData);

        $this->assertIsArray(($result));
        $this->assertCount(2, $result);
    }

    /**
     * @throws Throwable
     */
    public function testGetCurrencyShouldThrowNotFoundExceptionWhenCurrencyDoesNotExistAndDataIsNotCached()
    {
        Cache::shouldReceive('has')->once()->andReturn(false);
        $this->mockedPythonIntegrator
            ->expects($this->once())
            ->method('runCrawler')
            ->willReturn($this->crawlerData);
        Cache::shouldReceive('put')->once();
        Cache::shouldReceive('get')->once()->andReturn($this->crawlerData);

        $currencyService = new CurrencyService($this->mockedPythonIntegrator);

        $requestData = ['list' => ['XYZ', '123']];

        $this->expectException(NotFoundHttpException::class);
        $currencyService->getCurrency($requestData);
    }
}
