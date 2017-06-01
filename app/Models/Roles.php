<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
	protected $fillable = ['user_id', 'superAdmin', 'Admin'];

	public function user(){
		$this->belongsTo('App\User');
	}
   
}