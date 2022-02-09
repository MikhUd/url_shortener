<?php

namespace App\Http\Controllers;

use App\Services\ShortenUrlService;
use App\Http\Resources\UrlResource;
use App\Http\Requests\UrlRequest;
use Illuminate\Support\Facades\Redirect;

class ShortUrlController extends Controller
{
    private ShortenUrlService $urlService;

    public function __construct(ShortenUrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function shortenUrl(UrlRequest $request)
    {
        return $this->urlService->tryToGetShortenOrDeleteExpiredUrlByLongUrl($request->url);
    }

    public function redirectToUrl(string $token)
    {
        $url = $this->urlService->getUrlByToken($token);
        
        return Redirect::to($url);
    }
}
