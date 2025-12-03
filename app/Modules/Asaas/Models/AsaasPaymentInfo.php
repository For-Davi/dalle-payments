<?php

namespace App\Modules\Asaas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AsaasPaymentInfo extends Model
{
    use Notifiable;

    protected $table = 'payment_info';

    protected $fillable = [
        'payment_id',
        'user_id',
        'subscription_id',
        'month_quantity',
        'identifier',
    ];
}
