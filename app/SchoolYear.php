<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    public function schoolYear()
    {
        return $this->hasOne(User::class, 'school_year_id', 'id');
    }
}
