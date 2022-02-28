<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family_tree extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',      
    ];
   
    public function members()
    {
        return $this->hasMany(Members::class, 'family_tree_id', 'id');
    }
}
