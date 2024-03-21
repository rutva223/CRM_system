<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LeadStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pipeline_id',
        'created_by',
        'workspace_id',
        'order',
    ];

    public function lead()
    {
        if(Auth::user()->type == 'client')
        {
            return Deal::select('deals.*')->join('client_deals', 'client_deals.deal_id', '=', 'deals.id')->where('client_deals.client_id', '=', Auth::user()->id)->where('deals.stage_id', '=', $this->id)->orderBy('deals.order')->get();
        }
        else
        {
            return Lead::select('leads.*')->join('user_leads', 'user_leads.lead_id', '=', 'leads.id')->where('user_leads.user_id', '=', Auth::user()->id)->where('leads.stage_id', '=', $this->id)->orderBy('leads.order')->get();
        }
    }
}
