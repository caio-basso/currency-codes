<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCurrencyRequest;
use App\Services\CurrencyService;
use Throwable;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyService $currencyService
    ){}

    /**
     * @throws Throwable
     */
    public function index(GetCurrencyRequest $request): array
    {
        return $this->currencyService->getCurrency($request->validated());
    }
}
