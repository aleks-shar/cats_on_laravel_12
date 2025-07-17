<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @param array<string, mixed> $queryParams
     */
    public function __construct(
        private readonly array $queryParams,
    ) {
    }

    /**
     * @return array<string, callable>
     */
    abstract protected function getCallbacks(): array;

    public function apply(Builder $builder): void
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }
    }
}
