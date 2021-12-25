<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferHeader extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trans_no',
        'trans_date',
        'qty',
        'cost',
        'comments',
        'invo_no',
        'invo_date',
        'from',
        'to',
        'transfer_type_id',
        'user_id',
        'client_id',
    ];

    public function details()
    {
        return $this->hasMany(TransferDetails::class);
    }

    public function from_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from');
    }

    public function to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to');
    }

    public function transfer()
    {
        return $this->belongsTo(TransferType::class, 'transfer_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
