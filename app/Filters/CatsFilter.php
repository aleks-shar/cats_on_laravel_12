<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class CatsFilter extends AbstractFilter
{
    public const GENDER = 'gender';
    public const AGE = 'age';
    public const MIN_AGE = 'min_age';
    public const MAX_AGE = 'max_age';

    /**
     * @return array<string, callable>
     */
    protected function getCallbacks(): array
    {
        return [
            self::GENDER => [$this, 'gender'],
            self::AGE => [$this, 'age'],
            self::MIN_AGE => [$this, 'minAge'],
            self::MAX_AGE => [$this, 'maxAge'],
        ];
    }

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function gender(Builder $builder, mixed $value): void
    {
        $builder->where(['gender' => $value]);
    }

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function age(Builder $builder, mixed $value): void
    {
        $builder->where(['age' => $value]);
    }

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function minAge(Builder $builder, mixed $value): void
    {
        $builder->where('age', '>=', $value);
    }

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function maxAge(Builder $builder, mixed $value): void
    {
        $builder->where('age', '<=', $value);
    }
}
