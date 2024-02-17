<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'pipeline_id',
        'stage_id',
        'group_id',
        'sources',
        'products',
        'created_by',
        'notes',
        'labels',
        'phone',
        'permissions',
        'status',
        'is_active',
    ];

    public static $statues = [
        'Active' => 'Active',
        'Won' => 'Won',
        'Loss' => 'Loss',
    ];

    public static function getDealSummary($deals)
    {
        $total = 0;

        foreach($deals as $deal)
        {
            $total += $deal->price;
        }

        return $total;
    }
    public function labels()
    {
        if($this->labels)
        {
            return Label::whereIn('id', explode(',', $this->labels))->get();
        }

        return false;
    }

    public function tasks()
    {
        return $this->hasMany(DealTask::class, 'deal_id', 'id');
    }

    public function complete_tasks()
    {
        return $this->hasMany(DealTask::class, 'deal_id', 'id')->where('status', '=', 1);
    }
    public function products()
    {
        if($this->products)
        {
            return ProductService::whereIn('id', explode(',', $this->products))->get();
        }

        return [];
    }

    public function sources()
    {
        if($this->sources)
        {
            return Source::whereIn('id', explode(',', $this->sources))->get();
        }

        return [];
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_deals', 'deal_id', 'user_id');
    }

    public function files()
    {
        return $this->hasMany(DealFile::class, 'deal_id', 'id');
    }

    public function pipeline()
    {
        return $this->hasOne(Pipeline::class, 'id', 'pipeline_id');
    }

    public function stage()
    {
        return $this->hasOne(DealStage::class, 'id', 'stage_id');
    }

    public function emails()
    {
        return $this->hasMany(DealEmail::class, 'deal_id', 'id')->orderByDesc('id');
    }

    public function discussions()
    {
        return $this->hasMany(DealDiscussion::class, 'deal_id', 'id')->orderBy('id', 'desc');
    }

    public function clients()
    {
        return $this->belongsToMany(User::class, 'client_deals', 'deal_id', 'client_id');
    }

    public function calls()
    {
        return $this->hasMany(DealCall::class, 'deal_id', 'id');
    }
    public function activities()
    {
        return $this->hasMany(DealActivityLog::class, 'deal_id', 'id')->orderBy('id', 'desc');
    }

}
