<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransferDetails;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'unit_id',
        'category_id',
        'iprice',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getPriceAttribute()
    {
        $price = TransferDetails::where('item_id', $this->id)->orderBy('id', 'desc')->first();
        if($price) return $price->cost;
        return $this->iprice;
    }

    public function warehouses()
    {
        return $this->belongsToMany(\App\Models\Warehouse::class)->withPivot('qty');
    }

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
