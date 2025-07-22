<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Cat;
use Exception;

final class CatObserver
{
    /**
     * @param Cat $cat
     * @return void
     * @throws Exception
     */
    public function deleting(Cat $cat): void
    {
        if ($cat->kittens()->count() > 0 || $cat->fatheredKittens()->count() > 0) {
            throw new Exception('You can\'t remove a cat that has offspring.');
        }
    }
}
