<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
	protected $table = 'exercises';

	protected $fillable = [
		'name',
		'image',
		'description',
		'muscle'
	];
}
