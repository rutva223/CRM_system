<?php

namespace Database\Seeders;

use App\Models\DealStage;
use App\Models\LeadStage;
use App\Models\Pipeline;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->DefaultData();
    }
    public function DefaultData($id = null)
    {
        $pipelines = [
            'Sales',
        ];
        $stages = [
            'Appointment scheduled',
            'Qualified to buy',
            'Presentation scheduled',
            'Decision maker bought-In',
            'Contract sent',
            'Closed won',
            'Closed lost',
        ];
        $lead_stages = [
            "Draft",
            "Sent",
            "Open",
            "Revised",
            "Declined",
            "Accepted",
        ];
        if ($id) {
            $company = User::where('id', $id)->where('type', 'company')->first();
            foreach ($pipelines as $pipeline) {
                $Pipeline = Pipeline::where('name', $pipeline)->where('created_by', $company->id)->first();

                if ($Pipeline == null) {
                    $Pipeline = new Pipeline();
                    $Pipeline->name = $pipeline;
                    $Pipeline->created_by = !empty($company->id) ? $company->id : 2;
                    $Pipeline->save();
                }
            }
            foreach($stages as $stage)
            {
                $dealstage = DealStage::where('name',$stage)->where('created_by',$company->id)->first();

                if($dealstage == null){
                    $dealstage = new DealStage();
                    $dealstage->name = $stage;
                    $dealstage->pipeline_id = $Pipeline->id;
                    $dealstage->order = 0;
                    $dealstage->created_by = !empty($company->id) ? $company->id : 2;
                    $dealstage->save();
                }

            }
            foreach($lead_stages as $lead_stage)
                {
                    $leadstage = LeadStage::where('name',$lead_stage)->where('created_by',$company->id)->first();

                    if($leadstage == null){
                        $leadstage = new LeadStage();
                        $leadstage->name = $lead_stage;
                        $leadstage->pipeline_id = $Pipeline->id;
                        $leadstage->order = 0;
                        $leadstage->created_by = !empty($company->id) ? $company->id : 2;
                        $leadstage->save();
                    }
                }
        } else {
            $companyies = User::where('type', 'company')->get();
            foreach ($companyies as $company) {
                foreach ($pipelines as $pipeline) {
                    $Pipeline = Pipeline::where('name', $pipeline)->where('created_by', $company->id)->first();

                    if ($Pipeline == null) {
                        $Pipeline = new Pipeline();
                        $Pipeline->name = $pipeline;
                        $Pipeline->created_by = !empty($company->id) ? $company->id : 2;
                        $Pipeline->save();
                    }
                }
                foreach($stages as $stage)
                {
                    $dealstage = DealStage::where('name',$stage)->where('created_by',$company->id)->first();

                    if($dealstage == null){
                        $dealstage = new DealStage();
                        $dealstage->name = $stage;
                        $dealstage->pipeline_id = $Pipeline->id;
                        $dealstage->order = 0;
                        $dealstage->created_by = !empty($company->id) ? $company->id : 2;
                        $dealstage->save();
                    }

                }
                foreach($lead_stages as $lead_stage)
                {
                    $leadstage = LeadStage::where('name',$lead_stage)->where('created_by',$company->id)->first();
                    if($leadstage == null){
                        $leadstage = new LeadStage();
                        $leadstage->name = $lead_stage;
                        $leadstage->pipeline_id = $Pipeline->id;
                        $leadstage->order = 0;
                        $leadstage->created_by = !empty($company->id) ? $company->id : 2;
                        $leadstage->save();
                    }

                }
            }
        }

    }
}
