<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'parent_id',
        'service_name_en',
        'service_name_ar',
        'service_name_ur',
        'service_name_tr',
        'service_image',
    ];


    // Define the relationship to the parent service
    public function parent()
    {
        return $this->belongsTo(Services::class, 'parent_id');
    }

    // Define the relationship to the child services
    public function children()
    {
        return $this->hasMany(Services::class, 'parent_id');
    }



}
