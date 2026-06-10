<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyProgram extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'week_start' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function objectives()
    {
        return $this->hasMany(WeeklyProgramObjective::class);
    }

    public function progressPercentage(): float
    {
        $total = $this->objectives->count();
        if ($total === 0) return 0;
        $achieved = $this->objectives->where('status', 'achieved')->count();
        return round(($achieved / $total) * 100);
    }
}