<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OpdForm extends Model
{
    protected $fillable = ['name','form_no','department','schema'];
    protected $casts   = ['schema'=>'array']; // schema json → array
}