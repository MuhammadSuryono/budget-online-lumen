<?php

namespace App\Models\DigitalMarket;

use App\Models\ConstantDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataUser extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    protected $table = 'data_user';
    protected $connection = ConstantDatabase::DATABASE_DIGITAL_MARKETING;
}
