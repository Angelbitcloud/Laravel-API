<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Gym extends Model
{
    protected $table = 'users_gym';

    protected $fillable = [
        'name', 
        'lastname', 
        'cell', 
        'monthlyPayment', 
        'isActive'];

    protected $hidden = ['created_at', 'updated_at'];
}
