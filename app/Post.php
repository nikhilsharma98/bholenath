<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Table Name
    protected $table  = 'posts';
    //Primary Key
    Public $primarykey = '$id';
    //Timestamps
    Public $imestamps = 'true';


    Public function user(){
        return $this->belongsTo('App\User');
    }
}
