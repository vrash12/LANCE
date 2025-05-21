<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
protected $fillable = ['short_name','name'];
public function tokens()
{
    return $this->hasMany(Token::class);
}


public function nextPendingToken()
{
    return $this->hasOne(Token::class)
                ->whereNull('served_at')
                ->orderBy('created_at');   // earliest first
}

}