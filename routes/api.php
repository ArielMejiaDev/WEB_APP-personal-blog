<?php

use App\Jobs\MailJob;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    Route::get('blog/category/{slug}', 'BlogController@postsByTag');

    Route::get('blog/all', 'BlogController@all');

    Route::resource('blog', 'BlogController')->parameters(['blog' => 'slug']);

    Route::post('contact', function () {
        MailJob::dispatch();
        return 'emails sent';
    });

});
