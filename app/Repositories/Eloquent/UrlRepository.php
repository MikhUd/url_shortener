<?php

namespace App\Repositories\Eloquent;

use App\Models\ShortenUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class UrlRepository
{
    protected $model;

    public function __construct(ShortenUrl $model)
    {
        $this->model = $model;
    }

    /**
     * Создает новую короткую ссылку.
     *
     * @return Model
     */
    public function create(array $fields): ?Model
    {
        return $this->model->create($fields);
    }

    /**
     * Получает короткую ссылку по длинной.
     *
     * @return Model
     */
    public function getShortenUrlByLongUrl(string $longUrl): ?Model
    {
        return $this->model->where('long_url', $longUrl)->first();
    }

    /**
     * Получает оригинальную ссылку по токену.
     *
     * @return Collection
     */
    public function getUrlByToken(string $token): Collection
    {
        return $this->model->where('token', $token)->get('long_url');
    }

    /**
     * Удаляет истекшую короткую ссылку.
     *
     * @return bool
     */
    public function delete(ShortenUrl $shortenUrl): bool
    {
        return $shortenUrl->delete();
    }

}