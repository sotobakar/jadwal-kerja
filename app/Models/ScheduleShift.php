<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleShift extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'schedule_shift';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['shift', 'schedule', 'user'];

    /**
     * Get the shift of the shift schedule.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Get the schedule of the shift schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the user of the shift schedule.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
