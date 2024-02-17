<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealDiscussion extends Model
{
    use HasFactory;
    protected $fillable = [
        'deal_id',
        'comment',
        'created_by',
    ];
}
