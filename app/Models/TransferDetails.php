<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferDetails extends Model
{

    protected $fillable = [
        'transfer_header_id',
        'item_id',
        'qty',
        'cost'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function header()
    {
        return $this->belongsTo(TransferHeader::class, 'transfer_header_id');
    }
}
