<?php

namespace App\Http\Controllers;

use App\Services\ShortenUrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShortUrlController extends Controller
{
    private ShortenUrlService $urlService;

    public function __construct(ShortenUrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function shortenUrl(Request $request)
    {
        if (!$request->url) {
            return array('error' => 'URL is empty!');
        }

        if (!$this->urlService->checkUrlExists($longUrl = $request->url)) {
            return array('error' => 'You have entered a non-existent url');
        }

        return $this->urlService->tryToGetShortenUrlByLongUrl($longUrl);
    }

    public function redirectToUrl(string $token)
    {
        $url = $this->urlService->getUrlByToken($token);
        
        return Redirect::to($url);
    }
}
