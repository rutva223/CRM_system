<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLead extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', 'lead_id'
    ];
}
