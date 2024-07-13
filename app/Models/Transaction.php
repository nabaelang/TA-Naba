<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'user_id',
        'courier',
        'service',
        'cost_courier',
        'weight',
        'name',
        'phone',
        'province',
        'city',
        'address',
        'status_shipping',
        'snap_token',
        'grand_total'
    ];

    public function detail_transactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province', 'province_id');
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'city', 'city_id');
    }
}
