<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table ='leads';

    public static function lead_title() {
        $statusClass = [
            0 => 'to-do',
            1 => 'on-progress',
            2 => 'quality-control',
            3 => 'completed',
        ];

        return $statusClass;
    }
}
