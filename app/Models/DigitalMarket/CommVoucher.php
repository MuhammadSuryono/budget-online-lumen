<?php

namespace App\Models\DigitalMarket;

use App\Models\ConstantDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommVoucher extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    protected $table = 'comm_voucher';
    protected $connection = ConstantDatabase::DATABASE_DIGITAL_MARKETING;

    public function dataUser(): BelongsTo
    {
        return $this->belongsTo('App\Models\Db2\DataUser', 'id_user', 'research_executive');
    }
}
