<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class Ticket extends Model
{
    /**
     * The table.
     *
     * @var array
     */
    protected $table = 'tickets';

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'file_servcie_id',
        'parent_chat_id',
        'assign_id',
        'subject',
        'message',
        'document',
        'remain_file',
        'is_closed',
        'is_read'
    ];

    /**
     * Get the user that owns the company.
    */
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    /**
     * Get the user that owns the company.
    */
    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id');
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\User', 'assign_id');
    }

    /**
     * Get the user that owns the company.
    */
    public function fileService()
    {
        return $this->belongsTo('App\Models\FileService', 'file_servcie_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Ticket', 'parent_chat_id');
    }

    /**
     * Return the child messages array for this model.
     *
     * @return array
     */
    public function childrens() {
        return $this->hasMany('App\Models\Ticket', 'parent_chat_id', 'id');
    }

    /**
     * Get the company attribute.
    */
    public function getLastMessageAttribute() {
        if($this->childrens->count() > 0){
            return $this->childrens->orderBy('id', 'Desc')->first()->message;
        }else{
            return $this->message;
        }
    }

	/**
	* Get Read/Unread Status
	*/

	public function getUnreadMessage($user) {
        $count = 0;
        $children = $this->childrens();
        if ($user->is_admin) {
            if ($this->assign_id) return 1;
            $count = $this->receiver_id == $user->id && $this->is_read == 0 ? 1 : 0;
            $count += $children->where('receiver_id', $user->id)->where('is_read', 0)->count();
        } else if ($user->is_staff) {
            if ($this->assign_id != $user->id) return 1;
            $count = $this->receiver_id == $user->company->owner->id && $this->is_read == 0 ? 1 : 0;
            $count += $children->where('receiver_id', $user->company->owner->id)->where('is_read', 0)->count();
        } else {
            $count = $this->receiver_id == $user->id && $this->is_read == 0 ? 1 : 0;
            $count += $children->where('receiver_id', $user->id)->where('is_read', 0)->count();
        }
        return $count > 0 ? 0 : 1;
    }


    /**
     * Get the company attribute.
    */
    public function getCompanyAttribute() {
        return @$this->sender->company->name;
    }

	/**
     * Get the car attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getCarAttribute($value) {
        if ($this->fileService) {
            return $this->fileService->make.' '.$this->fileService->model.' '.$this->fileService->generation;
        } else {
            return '';
        }
    }

	/**
     * Get the File Service Name attribute.
    */
  	 public function getFileServiceNameAttribute() {
		if($this->fileService) {
			return $this->fileService->displayable_id;
		}else{
			//changes
				return 'General Enquiry';
		}
	}

	/**
     * Get the Customer's Name attribute.
    */
  	 public function getClientAttribute() {
		if($this->fileService != null) {
			return $this->fileService->user->first_name.' '.$this->fileService->user->last_name;
		}else{
			//changes
				$receiverID = @$this->receiver_id;
				return $this->sender->first_name.' '.$this->sender->last_name;
		}
	}

    /**
     * Get the created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value) {
        $timezone = Helper::companyTimeZone();
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }
}
