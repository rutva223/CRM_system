<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'deal_id',
    ];
    public function getDealUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
