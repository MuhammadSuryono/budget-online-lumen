<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubmissionBudget extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    protected $table = 'pengajuan';

    /**
     * @return HasMany
     */
    public function itemBudgets(): HasMany
    {
        return $this->hasMany('App\Models\Budget\ItemBudget', "waktu", "waktu");
    }
}
