<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_by',
        ];

    public function dealStages()
    {
        return $this->hasMany(DealStage::class, 'pipeline_id', 'id')->where('created_by', '=', creatorId())->orderBy('order');
    }

}
