<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'user_id',
        'f_name',
        'l_name',
        'email',
        'phone_no',
        'assistants_name',
        'assistants_mail',
        'assistants_phone',
        'department_name',
        'dob',
        'social_media_profile',
        'notes',
        'send_mail',
        // billing Address
        'billing_street',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        // shipping address
        'shipping_street',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
