<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealMeeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'deal_id',
        'subject',
        'call_type',
        'duration',
        'user_id',
        'description',
        'call_result',
    ];
    public static $status = [
        1 => 'Pending',
        2 => 'Complete',
        3 => 'Expired',
    ];
    public function getDealMeetingUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
