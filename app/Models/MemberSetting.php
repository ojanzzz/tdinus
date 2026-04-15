<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description',
    ];
}
