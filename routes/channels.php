<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.Customer.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
},['guards'=>['customer','api-customers']]);

Broadcast::channel('chat_{chat}',function($user,  $chat){
    return true;
},['guards'=>['customer','api-customers']]);

Broadcast::channel('user_chats_{customer_id}',function($user,  $customer_id){
    return $user->id == $customer_id;
},['guards'=>['customer','api-customers']]);

Broadcast::channel('customer_{customer_id}',function($user,  $customer_id){
    return true;
},['guards'=>['customer','api-customers']]);


