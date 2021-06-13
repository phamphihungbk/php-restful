<?php

namespace TinnyApi\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class WeakPasswordRule implements Rule
{
    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * WeakPasswordRule constructor.
     *
     * @param CacheRepository $cacheRepository
     */
    public function __construct(CacheRepository $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value): bool
    {
        $path = realpath(__DIR__ . '/weak_password_list.txt');

        $data = $this->cacheRepository->rememberForever('weak_password_list', function () use ($path) {
            return collect(explode("\n", file_get_contents($path)));
        });

        return !$data->contains($value);
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        return __('This password is just too common. Please try another!');
    }
}
