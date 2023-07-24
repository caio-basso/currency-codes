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
     * @OA\Post(
     *     path="/api/currency",
     *     tags={"Currency"},
     *     summary="Get currency information",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="list", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="422", description="Invalid Input"),
     * )
     */
    public function index(GetCurrencyRequest $request): array
    {
        return $this->currencyService->getCurrency($request->validated());
    }
}
