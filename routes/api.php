<?php

use App\Models\Ad;
use App\Models\Filter;
use App\Models\Customer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;
use App\Notifications\TestNotification;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\AbuseController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\CommentReplyController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Customer\ChatController;
use App\Http\Controllers\Api\Customer\CommissionController;
use App\Http\Controllers\Api\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Api\Customer\ProfileController as CustomerProfileController;
use App\Models\ChatMessage;

Route::group(['middleware'=>'acceptLocale'],function(){
    Route::get('offers/{offer}',[OfferController::class,'show']);
    Route::get('offers',[OfferController::class,'index']);

    Route::get('pages/{page}',[PageController::class,'show']);
    Route::get('banks',[DataController::class,'getBanks']);

    Route::get('carsAgencies', [\App\Http\Controllers\Api\CarsAgenciesController::class,'index']);

    Route::get('departments/{department}/categories',[DataController::class,'getDepartmentCategories']);
    Route::get('categories/{parent_id?}',[CategoryController::class,'getCategories']);
    Route::post('contact_us',[ContactUsController::class,'sendContact']);


    Route::group(['prefix'=>'v2'],function(){
        Route::get('get-departments',[DataController::class,'getDepartmentsV2']);
        Route::get('get-parent-categories/{department}',[DataController::class,'getParentCategories']);
        Route::get('get-sub-categories/{category}',[DataController::class,'getSubCategories']);
        Route::get('get-admodels/{category}',[DataController::class,'getCategoryAdmodels']);
    });

    Route::get('get-regions',[DataController::class,'getRegions']);
    Route::get('get-departments',[DataController::class,'getDepartments']);
    Route::get('get-admodels',[DataController::class,'getAdmodels']);

    Route::get('customer/{customer}/ads',[AdController::class,'customer']);
    Route::get('customer/{customer}/details',[CustomerAuthController::class,'show']);


    Route::post('customer-auth/login', [CustomerAuthController::class, 'login']);
    Route::post('customer-auth/register', [CustomerAuthController::class, 'register']);
    Route::post('customer-auth/forgot-password', [CustomerAuthController::class,'sendResetPasswordCode']);
    Route::post('customer-auth/verify-forgot-password-code', [CustomerAuthController::class,'verifyForgetPasswordCode']);
    Route::post('customer-auth/reset-password', [CustomerAuthController::class,'saveResetPassword']);
    Route::post('customer-verify', [CustomerAuthController::class,'verifyAccount']);
    Route::post('customer-resend-verification-code', [CustomerAuthController::class,'resendActivationCode']);

    Route::get('ads/home',[SearchController::class,'homeAds']);


    Route::get('ad/{ad}/comments',[CommentController::class,'index']);
    Route::get('ad/{ad}/similar',[AdController::class,'similar']);
    Route::get('ad/{ad_id}',[AdController::class,'show']);

    Route::get('ads/search',[SearchController::class,'index']);

    Route::get('contact-settings',[DataController::class,'contactSettings']);
    Route::get('settings',[DataController::class,'contactSettings']);


    Route::get('comment/{comment}/replies',[CommentReplyController::class,'index']);
    Route::group(['middleware'=>['auth:api-customers','verified','logoutInactiveCustomer']], function () {

        Route::get('check-follow-filter',[FilterController::class,'check']);

        Route::post('read-all-chat-messages/{customer}',function($customer){
            ChatMessage::where(['customer2_id'=>auth('api-customers')->id(),'customer1_id'=>$customer])->update(['read_at'=>now()]);
            return response()->json(['read'=>1]);
        });

        Route::post('in-chat',[ChatController::class,'inChat']);
        Route::post('chat', [ChatController::class,'store']);

        Route::get('chat/getRooms', [ChatController::class,'getRooms']);
        Route::get('chat/{customer}',[ChatController::class,'getCustomerChats']);
        Route::post('chat/search',[ChatController::class,'getCustomerChatSearch']);


        Route::get('refresh-token',function(){
            $token = JWTAuth::getToken();
            return response()->json(['token'=>JWTAuth::refresh($token)]);
        });

        Route::post('ad/{ad}/comment',[CommentController::class,'store']);
        Route::delete('comment/{comment}',[CommentController::class,'delete']);

        Route::delete('comment-reply/{comment_reply}',[CommentReplyController::class,'delete']);
        Route::post('comment/{comment}/reply',[CommentReplyController::class,'store']);

        Route::post('ad',[AdController::class,'store']);
        Route::post('ad/{ad}/renew',[AdController::class,'renewAd']);
        Route::post('ad/{ad}/edit',[AdController::class,'update']);
        Route::delete('ad/{ad}',[AdController::class,'delete']);
        Route::post('ad/{ad}/abuse',[AbuseController::class,'store']);
        Route::post('ad/{ad}/toggle-like',[LikeController::class,'toggle']);
        Route::post('filter',[FilterController::class,'store']);
        Route::post('filter/{id}',[FilterController::class,'get']);

        Route::get('search-my-ads',[SearchController::class,'myAds']);

        Route::group(['prefix' => 'customer','namespace'=>'Api\Customer'],function(){

            Route::get('commissions',[CommissionController::class,'index']);
            Route::get('commission/{commission_transfer}',[CommissionController::class,'show']);
            Route::post('commission',[CommissionController::class,'store']);

            Route::get('my-ads',[SearchController::class,'myAds']);
            Route::post('/logout', [CustomerAuthController::class, 'logout'])->middleware('jwt.auth');
            Route::post('change-password',[CustomerProfileController::class,'changePassword']);

            Route::post('request-change-mobile',[CustomerProfileController::class,'requestChangeMobileNumber']);
            Route::post('save-change-mobile',[CustomerProfileController::class,'saveChangeMobileNumber']);

            Route::get('profile',[CustomerProfileController::class,'getProfile']);
            Route::post('profile',[CustomerProfileController::class,'setProfile']);

            Route::get('followers',[FollowController::class,'followers']);

            Route::prefix('notifications')->group(function (){
                Route::get('/',[NotificationController::class,'index']);
                Route::get('unread',[NotificationController::class,'unread']);
            });

            Route::post('rating',[RatingController::class,'store']);

            Route::post('follow',[FollowController::class,'store']);
            Route::get('following',[FollowController::class,'following']);

            Route::post('favorite/{ad}',[FavoriteController::class,'toggle']);
            Route::get('favorites',[FavoriteController::class,'index']);

            Route::get('chat/unread',[ChatController::class,'unread']);

        });

    });/*Requires user authentication*/
});


