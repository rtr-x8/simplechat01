<?php

namespace App\Http\Controllers\Api\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountDownChatBotController extends Controller
{
    public function callback(Request $request)
    {
        return response()->setStatusCode(200, 'Hello Line !');
    }
}
