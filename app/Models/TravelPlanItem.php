<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_plan_id',
        'post_id',
        'note',
        'order',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(TravelPlan::class, 'travel_plan_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
