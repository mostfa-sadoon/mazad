<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTranslation extends Model
{
    //
    protected $guarded=[];
    public $tables='term_translations';
    protected $translationForeignKey='term_id';
    public $timestamps = false;

}
