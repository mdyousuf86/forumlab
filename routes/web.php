<?php

use App\Lib\CurlRequest;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('fetch/data', function () {
    $data = CurlRequest::curlContent("https://script.viserlab.com/forumlab/fetch/data");
    foreach (json_decode($data) as $item) {
        $user=new User();
        $user->id=$item->id;
        $user->firstname=$item->firstname;
        $user->lastname=$item->lastname;
        $user->username=$item->username;
        $user->email=$item->email;
        $user->country_code=$item->country_code;
        $user->mobile=$item->mobile;
        $user->password=$item->password;
        $user->image=$item->image;
        $user->address=$item->address;
        $user->status=$item->status;
        $user->about=$item->about;
        $user->ev=$item->ev;
        $user->sv=$item->sv;
        $user->ver_code=$item->ver_code;
        $user->profile_complete=1;
        $user->ver_code_send_at=$item->ver_code_send_at;
        $user->remember_token=$item->remember_token;
        $user->created_at=$item->created_at;
        $user->save();
    }
});
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    Route::get('ad-redirect/{hash}', 'adRedirect')->name('ad.redirect');
    Route::get('ad-count-ajax', 'adCountAjax')->name('ad.count.ajax');

    Route::get('all/topics', 'index')->name('all.topic');
    Route::get('category/{slug}/{id}', 'categoryTopics')->name('category.topic');
    Route::get('subcategory/{slug}/{id}', 'subCategoryTopics')->name('subcategory.topics');
    Route::get('forums/{slug}/{id}', 'forums')->name('forums');

    Route::get('topic/detail/{slug}/{id}', 'detail')->name('topic.detail');
    Route::get('fetch/comments/{id}', 'fetchComments')->name('fetch.comments');

    Route::get('profile/{username}', 'profile')->name('profile');
    Route::get('topics/{username}', 'profile')->name('profile.topics');
    Route::get('topics/answered/{username}', 'profile')->name('profile.answered');
    Route::get('profile/up-vote/{username}', 'profile')->name('profile.up.vote');
    Route::get('profile/down-vote/{username}', 'profile')->name('profile.down.vote');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});
