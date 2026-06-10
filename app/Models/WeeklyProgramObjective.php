<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyProgramObjective extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function weeklyProgram()
    {
        return $this->belongsTo(WeeklyProgram::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}