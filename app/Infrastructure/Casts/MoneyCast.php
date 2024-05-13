<?php

declare(strict_types=1);

namespace App\Infrastructure\Casts;

use App\Domain\Enums\CurrencyEnum;
use App\Domain\ValueObjects\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new Money($attributes[$key], CurrencyEnum::tryFrom($attributes['currency']) ?? CurrencyEnum::USD);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (! $value instanceof Money) {
            throw new \InvalidArgumentException();
        }

        return [
            'currency' => $value->currency,
            $key => $value->amount,
        ];
    }
}
