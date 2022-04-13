<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConveyanceBill extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Relation between Conveyance bill and employee
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relation between Conveyance bill and bill type
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billType()
    {
        return $this->belongsTo(BillType::class);
    }

}
