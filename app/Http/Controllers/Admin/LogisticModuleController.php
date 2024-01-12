<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Currency;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;

class LogisticModuleController extends Controller
{
    public function index()
    {
        return view('admin-views.business-settings.logistic.index');
    }

    public function update(Request $request, $module)
    {
        if ($module == 'redx_courier') {
            $payment = BusinessSetting::where('type', 'redx_courier')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'redx_courier',
                    'value' => json_encode([
                        'status' => 1,
                        'environment' => 'sandbox',
                        'access_token' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                if ($request['status'] == 1) {
                    $request->validate([
                        'access_token' => 'required'
                    ]);
                }
                DB::table('business_settings')->where(['type' => 'redx_courier'])->update([
                    'type' => 'redx_courier',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'environment' => $request['environment'],
                        'access_token' => $request['access_token']
                    ]),
                    'updated_at' => now()
                ]);
            }
        }
        Toastr::success(translate('successfully_updated'));

        return back();
    }
}
