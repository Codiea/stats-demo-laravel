<?php

namespace App\Models;

use Database\Factories\SalesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];
    use HasFactory;
    

    protected static function newFactory()
    {
        return SalesFactory::new();
    }
}
