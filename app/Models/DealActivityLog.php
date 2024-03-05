<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'deal_id',
        'log_type',
        'remark',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getUser()
    {
        $user = $this->user;
        $user_name = $user->name;
        return $user_name;
    }
    public function getUseremail()
    {
        $user = $this->user;
        $user_email = $user->email;
        return $user_email;
    }
    public function getRemark()
    {
        $remark = json_decode($this->remark, true);

        if($remark)
        {
            $user = $this->user;

            if($user)
            {
                $user_name = $user->name;
            }
            else
            {
                $user_name = '';
            }
            if($this->log_type == 'Upload File')
            {
                return __('Upload new file') . ' <b>' . $remark['file_name'] . '</b>';
            }
            elseif($this->log_type == 'Create Task')
            {
                return __('Create new Task') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Add Product')
            {
                return __('Add new Products') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Update Sources')
            {
                return __('Update Sources');
            }
            elseif($this->log_type == 'Create Deal Call')
            {
                return __('Create new Deal Call');
            }
            elseif($this->log_type == 'Create Deal Email')
            {
                return __('Create new Deal Email');
            }
            elseif($this->log_type == 'Create Meeting')
            {
                return __('Create new Meeting');
            }
            elseif($this->log_type == 'Move')
            {
                return $user_name . " " . __('Moved the deal') . " <b>" . $remark['title'] . "</b> " . __('from') . " " . __(ucwords($remark['old_status'])) . " " . __('to') . " " . __(ucwords($remark['new_status']));
            }
        }
        else
        {
            return $this->remark;
        }
    }

    public function logIcon()
    {
        $type = $this->log_type;
        $icon = '';

        if(!empty($type))
        {
            if($type == 'Move')
            {
                $icon = 'fa-arrows-alt';
            }
            elseif($type == 'Add Product')
            {
                $icon = 'fa-dolly';
            }
            elseif($type == 'Upload File')
            {
                $icon = 'fa-file-alt';
            }
            elseif($type == 'Update Sources')
            {
                $icon = 'fa-pen';
            }
            elseif($type == 'Create Deal Call')
            {
                $icon = 'fa-phone';
            } elseif($type == 'Create Meeting')
            {
                $icon = 'fa-handshake-o';
            }
            elseif($type == 'Create Deal Email')
            {
                $icon = 'fa-envelope';
            }
            elseif($type == 'Create Invoice')
            {
                $icon = 'fa-file-invoice';
            }
            elseif($type == 'Add Contact')
            {
                $icon = 'fa-address-book';
            }
            elseif($type == 'Create Task')
            {
                $icon = 'fa-tasks';
            }
        }

        return $icon;
    }
}
