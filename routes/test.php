<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\CPU\Helpers;
Route::get('aws-data', function () {
    return "bdsb";
    return view('installation.step5');
    $mail_config = Helpers::get_business_settings('mail_config');
     return $mail_config['status']??0;
    return view('welcome');
});
Route::get('order-email',function(){
    $id = 100207;
    return view('email-templates.order-placed-v2',compact('id'));
});
Route::post('aws-upload', function (Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imageName = time() . '.' . $request->image->extension();

    $path = Storage::disk('s3')->put('images', $request->image);
    $path = Storage::disk('s3')->url($path);

    dd($path);
    /* Store $imageName name in DATABASE from HERE */
    return back()
        ->with('success', 'You have successfully upload image.')
        ->with('image', $path);
})->name('aws-upload');


