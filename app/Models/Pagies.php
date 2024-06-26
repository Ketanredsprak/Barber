<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagies extends Model
{
    use HasFactory;

    protected $table = 'pagies';

    protected $fillable = [
        'key',
        'page_name_en',
        'page_name_ar',
        'page_name_ur',
        'page_name_tr',
    ];


    public function meta_content(){
        return $this->hasOne(MetaContent::class, 'page_id', 'id');
    }

    public function cms_content(){
        return $this->hasMany(Cms::class, 'page_id', 'id');
    }
}
