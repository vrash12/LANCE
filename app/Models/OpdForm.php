<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdForm extends Model
{
 protected $fillable = [
  'name','form_no','department','fields',
];

    protected $casts = [
        'fields'  => 'array',  // ← so you get an array in PHP
    ];

public function submissions()
{
    return $this->hasMany(OpdSubmission::class, 'form_id');
}
}
