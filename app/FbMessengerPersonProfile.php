<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FbMessengerPersonProfile extends Model
{
    use SoftDeletes;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fb_messenger_person_profile';
	
	protected $fillable = [
       'page_id', 'psid', 'mpp_first_name', 'mpp_last_name', 'mpp_profile_pic', 'mpp_locale', 'mpp_gender', 'like', 'bot', 'block', 'interaction'
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
