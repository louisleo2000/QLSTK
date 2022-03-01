<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;
    protected $fillable = [
        'family_tree_id',
        'name',
        'dob',
        'dod',
        'gender',
        'img',
        'father_id',
        'mother_id',
        'couple_id',
    ];
    public function familyTree()
    {
        return $this->belongsTo(Family_tree::class, 'id', 'family_tree_id');
    }  
}
