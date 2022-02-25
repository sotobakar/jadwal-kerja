<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get shift start time in HH:mm format.
     *
     * @param  string  $value
     * @return string
     */
    public function getStartTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }

    /**
     * Get shift end time in HH:mm format.
     *
     * @param  string  $value
     * @return string
     */
    public function getEndTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }
}
