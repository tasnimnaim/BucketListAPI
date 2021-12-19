<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BucketList extends Model
{
    //use HasFactory;
    protected $fillable = [
        'id',
        'email',
        'date',
        'bucketList',
        'published_at',
        'created_at',
        'updated_at',
        'otherbuketlist',
        'bucketId',
        'bucketItems'
    ];

    


}
