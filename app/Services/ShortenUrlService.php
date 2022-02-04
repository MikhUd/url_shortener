<?php

namespace App\Services;

use App\Models\ShortenUrl;
use App\Repositories\Eloquent\UrlRepository;
use Carbon\Carbon;

class ShortenUrlService
{
    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * Проверяет существование указанного url.
     *
     * @return bool
     */
    public function checkUrlExists(string $url): bool
    {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HEADER, 1);
        curl_setopt($curl,CURLOPT_NOBODY, 1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_FRESH_CONNECT, 1);

        if (!curl_exec($curl)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Возвращает рандомный токен.
     *
     * @return string
     */
    public function getToken(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chars_length = strlen($chars);
        $token = '';
        for ($i = 0; $i < 10; $i++) {
            $token .= $chars[mt_rand(0, $chars_length - 1)];
        }
        
        return $token;
    }

    /**
     * Возвращает короткую ссылку.
     *
     * @return ShortenUrl
     */
    public function tryToGetShortenUrlByLongUrl(string $longUrl): ?ShortenUrl
    {
        $shortenUrl = $this->urlRepository->getShortenUrlByLongUrl($longUrl);

        if ($shortenUrl && Carbon::parse($shortenUrl->expired_at)->gt(now())) {  
            return $shortenUrl;
        }
        
        if ($shortenUrl) {
            $this->deleteExpiredUrl($shortenUrl);
        }
         
        return $this->createShortenUrl($longUrl);
    }

    /**
     * Создает новую короткую ссылку.
     *
     * @return ShortenUrl
     */
    public function createShortenUrl(string $longUrl): ShortenUrl
    {
        $fields = array(
            'token' => $this->getToken(),
            'long_url' => $longUrl,
            'expired_at' => Carbon::now()->addHour(),
        );
        
        return $this->urlRepository->create($fields);
    }

    /**
     * Возвращает оригинальную ссылку по токену.
     *
     * @return ShortenUrl
     */
    public function getUrlByToken(string $token): string
    {
        return $this->urlRepository->getUrlByToken($token)[0]['long_url'];
    }

    /**
     * Удаляет короткую ссылку с просроченным токеном.
     *
     * @return void
     */
    public function deleteExpiredUrl(ShortenUrl $shortenUrl): void
    {
        $this->urlRepository->delete($shortenUrl);
    }
}
