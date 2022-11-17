<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TraitUuid;

class UserDiscord extends User
{
    use HasFactory, SoftDeletes, TraitUuid;

    protected $table = 'users_discord';
}
