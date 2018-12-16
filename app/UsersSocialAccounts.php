<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersSocialAccounts extends Model
{
	use SoftDeletes;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_social_accounts';
	
	protected $fillable = [
        'provider_user_id', 'provider', 'provider_token', 'long_provider_token', 'provider_user_gender', 'provider_user_birthday', 'provider_user_age_range', 'provider_user_link', 'provider_user_likes',
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
