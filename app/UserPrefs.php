<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPrefs extends Model {

	//
		protected $table = 'users_prefs';
		protected $fillable = ['email','user_prefs','previous_update'];
		


}
