<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\Filterable;
use Carbon\Carbon;
use Database\Factories\CatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property ?int $mother_id
 * @property string $name
 * @property string $gender
 * @property int $age
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Cat extends Model
{
    /** @use HasFactory<CatFactory> */
    use HasFactory;
    use Filterable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender',
        'age',
        'mother_id',
    ];

    /**
     * @return BelongsTo
     */
    public function mother(): BelongsTo
    {
        return $this->belongsTo(Cat::class, 'mother_id');
    }

    /**
     * @return BelongsToMany
     */
    public function fathers(): BelongsToMany
    {
        return $this->belongsToMany(Cat::class, 'cat_fathers', 'kitten_id', 'father_id');
    }

    /**
     * @return HasMany
     */
    public function kittens(): HasMany
    {
        return $this->hasMany(Cat::class, 'mother_id');
    }

    /**
     * @return BelongsToMany
     */
    public function fatheredKittens(): BelongsToMany
    {
        return $this->belongsToMany(Cat::class, 'cat_fathers', 'father_id', 'kitten_id');
    }
}
