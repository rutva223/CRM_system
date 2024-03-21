<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLead extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lead_id',
    ];

    public function getLeadUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
