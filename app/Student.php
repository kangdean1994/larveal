<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected  $primaryKey = "id";
    protected  $table="student";
    public  $timetamps = false;
}
