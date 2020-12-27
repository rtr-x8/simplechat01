<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;

class VerifyLineRequest
{
    /**
     * LINEからのリクエストか検証します。
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        if (empty($signature)) {
            Log::warning(__('count_down_bot.request.header_missing'));
            return response('Bad Request', 400);
        }

        $channelSecret = config('line-bot.channel_secret');
        $httpRequestBody = $request->getContent();
        $hash = hash_hmac('sha256', $httpRequestBody, $channelSecret);

        if (base64_encode($hash) !== $signature) {
            Log::warning(__('count_down_bot.request.header_wrong'));
            return response('Bad Request', 400);
        }

        return $next($request);
    }
}
