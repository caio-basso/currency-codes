<?php

namespace App\Services;

use App\Integrator\PythonIntegrator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CurrencyService
{
    private const CACHE_KEY_NAME = 'crawler_data';
    private const DAY_IN_MINUTES = 1440;
    private array $filteredValues = [];

    public function __construct(
        protected PythonIntegrator $pythonIntegrator
    ){}

    /**
     * @throws Throwable
     */
    public function getCurrency(array $requestData): array
    {
        if (!Cache::has(self::CACHE_KEY_NAME)) {
            $crawlerData = $this->pythonIntegrator->runCrawler();
            Cache::put(self::CACHE_KEY_NAME, $crawlerData, self::DAY_IN_MINUTES);
        }

        $crawlerData = Cache::get(self::CACHE_KEY_NAME);
        $crawlerDataCollection = collect($crawlerData);

        $currencyList = Arr::get($requestData, 'list');

        foreach ($currencyList as $value) {
            $this->filteredValues[] = is_numeric($value)
                ? $crawlerDataCollection->where('number', $value)
                : $crawlerDataCollection->where('code', $value);
        }

        $this->listValidator();

        return $this->filteredValues;
    }

    /**
     * @throws Throwable
     */
    private function listValidator(): void
    {
        $this->filteredValues = collect($this->filteredValues)->filter(function ($collection) {
            return $collection->isNotEmpty();
        })->values()->all();

        throw_if(empty($this->filteredValues), new NotFoundHttpException('Currency Not Found'));
    }
}
