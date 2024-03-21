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
    public static $priority = [
        'Low' => 'Low',
        'High' => 'High',
        'Medium' => 'Medium',
    ];

    public function stage()
    {
        return $this->hasOne(LeadStage::class, 'id', 'stage_id');
    }
    public function labels()
    {
        if($this->labels)
        {
            return Label::whereIn('id', explode(',', $this->labels))->get();
        }

        return false;
    }


    public function files()
    {
        return $this->hasMany(LeadFile::class, 'lead_id', 'id');
    }

    public function pipeline()
    {
        return $this->hasOne(Pipeline::class, 'id', 'pipeline_id');
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
        return $this->belongsToMany(User::class, 'user_leads', 'lead_id', 'user_id');
    }

    public function activities()
    {
        return $this->hasMany(LeadActivityLog::class, 'lead_id', 'id')->orderBy('id', 'desc');
    }

    public function calls()
    {
        return $this->hasMany(LeadCall::class, 'lead_id', 'id');
    }

    public function emails()
    {
        return $this->hasMany(LeadEmail::class, 'lead_id', 'id')->orderByDesc('id');
    }

    public function tasks()
    {
        return $this->hasMany(LeadTask::class, 'lead_id', 'id');
    }
    public function meetings()
    {
        return $this->hasMany(LeadMeeting::class, 'lead_id', 'id');
    }
}
