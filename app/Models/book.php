<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = [
        'name',
        'description',
        'image',
        'author_id',
        'date',
    ];

public function authors(){
  return $this->hasMany(author::class);
}

}
