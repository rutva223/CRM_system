<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $table ='coupons';
    protected $fillable = [
        'name',
        'coupon_code',
        'coupon_exp_date',
        'discount',
        'limit',
        'description',
        'is_active',
    ];
}
