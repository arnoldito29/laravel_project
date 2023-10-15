<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'license_plate',
        'model_id',
        'fuel_tank_capacity',
        'average_fuel',
        'estimated_distance',
    ];

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }
}
