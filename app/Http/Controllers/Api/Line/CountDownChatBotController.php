<?php

namespace App\Http\Controllers\Api\Line;

use App\Exceptions\ChatBotLogicException;
use App\Http\Controllers\Controller;
use CountDownChat\Infrastructure\EventHandler\Line\SelectEventHandlers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINEBot;

class CountDownChatBotController extends Controller
{
    /**
     * @var SelectEventHandlers
     */
    private SelectEventHandlers $selectEventHandlers;

    /**
     * CountDownChatBotController constructor.
     * @param  SelectEventHandlers  $selectEventHandlers
     */
    public function __construct(
        SelectEventHandlers $selectEventHandlers
    ) {
        $this->selectEventHandlers = $selectEventHandlers;
    }

    /**
     * @param  Request  $request
     * @return Application|ResponseFactory|Response
     * @throws ChatBotLogicException
     */
    public function callback(Request $request)
    {
        $events = $this->getEvent($request);

        foreach ($events as $event) {
            $eventHandler = $this->selectEventHandlers->select($event);
            if (is_null($eventHandler)) {
                continue;
            }
            $eventHandler->handle();
        }

        return response('OK', 200);
    }

    /**
     * リクエストからイベントを取り出す。
     * @link https://github.com/line/line-bot-sdk-php/blob/master/examples/KitchenSink/src/LINEBot/KitchenSink/Route.php#L72
     *
     * @param  Request  $request
     * @return Application|ResponseFactory|Response|mixed
     * @throws ChatBotLogicException
     */
    private function getEvent(Request $request)
    {
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        try {
            $events = LINEBot::parseEventRequest($request->getContent(), $signature);
        } catch (InvalidSignatureException $e) {
            $error = new ChatBotLogicException(
                'Invalid signature',
                0,
                $e,
                [
                    'ip' => $request->getClientIp(),
                    'signature' => $signature
                ]
            );
            $error->report();
            throw $error;
        } catch (InvalidEventRequestException $e) {
            $error = new ChatBotLogicException(
                'Invalid event request',
                0,
                $e,
                [
                    'ip' => $request->getClientIp(),
                    'signature' => $signature
                ]
            );
            $error->report();
            throw $error;
        }

        return $events;
    }
}
