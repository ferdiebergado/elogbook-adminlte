<?php

namespace Modules\Documents\Entities;

use App\BaseModel;
use Modules\Documents\Entities\Transaction;

class Attachment extends BaseModel
{
    protected $fillable = [
        'transaction_id',
        'filename',
        'path',
        'url',
        'drive'
    ];
    public function transaction()
    {
    	return $this->belongsTo(Transaction::class);
    }
}
