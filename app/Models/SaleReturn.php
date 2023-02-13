<?php

namespace App\Models;

use Database\Factories\SaleReturnFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return SaleReturnFactory::new();
    }
}
