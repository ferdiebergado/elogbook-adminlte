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
    protected $casts = [
        'transaction_id' => 'integer'
    ];
    public function transaction()
    {
    	return $this->belongsTo(Transaction::class);
    }
}
