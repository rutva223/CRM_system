<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::where('is_free_plan',1)->first();
        if(empty($plans))
        {
            $new_pan = new Plan();
            $new_pan->name = "Basic";
            $new_pan->price = 0;
            $new_pan->max_user = 5;
            $new_pan->max_customer = 5;
            $new_pan->max_vendor = 5;
            $new_pan->duration = 'Lifetime';
            $new_pan->description = 'Free Plan';
            $new_pan->is_free_plan = 1;
            $new_pan->save();
        }
    }
}
