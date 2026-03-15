<?php 

namespace App\Controllers\Admin;

use App\Models\SettingModel;

class SettingController extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function payment()
    {
        $data['settings'] = $this->settingModel->getPaymentSetting();
        return view('admin/setting/payment/index', $data); 
    }

    public function updatePayment()
    {
        $enabled = $this->request->getPost('metode_pembayaran') ?? []; // array
        $encoded = json_encode($enabled);

        // Misalnya setting disimpan di tabel 'settings' dengan key 'payment_methods'
        $settingModel = new \App\Models\SettingModel();
        $settingModel->where('name', 'payment_setting')
                    ->set(['value' => $encoded])
                    ->update();

        return redirect()->back()->with('success', 'Metode pembayaran diperbarui.');
    }

}
