<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'avatar',
        'lang',
        'plan',
        'plan_expire_date',
        'last_login_at',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function creatorId()
    {
        if($this->type == 'company' || $this->type == 'super admin')
        {
            return $this->id;
        }
        else
        {
            return $this->created_by;
        }
    }

    public static  function CompanySetting(){

    }

    public function assignPlan($planID)
    {
        if($planID)
        {
            try {
                $id       = Crypt::decrypt($planID);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Plan Not Found.'));
            }

        }
        $plan = Plan::find($id);
        $duration = $plan->duration;
        $user = User::find(Auth::user()->id);
        if(!empty($duration))
        {
            if($duration == 'Monthly')
            {
                $user->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($duration == 'Yearly')
            {
                $user->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($duration == 'Lifetime')
            {
                $user->plan_expire_date = Carbon::now()->addYears(10)->isoFormat('YYYY-MM-DD');
            }
            else{
                $user->plan_expire_date = null;
            }
        }else
        {
            $user->plan_expire_date = null;
            // for days
            // $this->plan_expire_date = Carbon::now()->addDays($duration)->isoFormat('YYYY-MM-DD');
        }

        $users = User::where('created_by',$user->id)->where('is_active',1)->get();
        $total_users =  $users->count();
        if($plan->max_user > 0)
        {
            if($total_users > $plan->max_user){
                    $count_user = $total_users - $plan->max_user;
                    $usersToDisable = User::orderBy('created_at', 'desc')->where('created_by',$user->id)->where('is_active',1)->take($count_user)->get();
                    foreach($usersToDisable as $item){
                        $item->is_active = 0;
                        $item->save();
                    }
            }else{
                $count_user =  $plan->max_user - $total_users ;
                $users = User::where('created_by',$user->id)->where('is_active',0)->take($count_user)->get();
                foreach($users as $item){
                    $item->is_active = 1;
                    $item->save();
                }
            }
        }elseif($plan->max_user == -1){
            $users = User::where('created_by',$user->id)->get();
            foreach($users as $item){
                $item->is_active = 1;
                $item->save();
            }
        }
        $user->plan = $plan->id;
        $user->total_user = $plan->max_user;
        $user->save();
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'user_deals', 'user_id', 'deal_id');
    }

}
