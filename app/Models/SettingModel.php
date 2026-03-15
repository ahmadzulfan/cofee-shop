<?php

namespace App\Models;

use CodeIgniter\Model;
const PAYMENT_SETTING = 'payment_setting';

class SettingModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'value'];

    public function getPaymentSetting()
    {
        $paymentSetting = $this->where('name', PAYMENT_SETTING)->first();
        $raw = $paymentSetting['value'];
        return json_decode($raw, true);
    }
}
