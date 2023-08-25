<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name'];
}
