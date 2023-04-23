<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendContactRequest;

class ContactUsController extends Controller
{
    public function sendContact(SendContactRequest $request){
        Contact::create(array_merge($request->validated(),['status'=>'unreplied']));
        return response()->json(['message'=>__('site.contact_saved')]);
    }
}
