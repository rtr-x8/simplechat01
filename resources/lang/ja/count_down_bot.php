<?php

return [
    'chara' => [
        'today' => '今日',
        'x_day' => 'Xデー',
        'executed_day' => '実行日'
    ],
    'hello' => 'こんにちは。',
    'welcome' => '友達登録ありがとう！',
    'introduction' => 'カウントダウンBOTです！',
    'message' => [
        'default' => ":xDayまで、\nあと:day日です。"
    ],
    'exception' => [
        'expiredXDay' => ''
    ],
    'request' => [
        'header_wrong' => ':ipから不正なLINEリクエストヘッダによるリクエストがありました。',
        'header_missing' => ':ipからLINEリクエストヘッダが空白のリクエストがありました。',
    ],
    'check_date' => [
        'command' => [
            'executed' => ':datetime に日付を計算するバッチ処理「chatbot:checkdate」が起動しました。',
            'result' => ':linerCount 人のユーザーに、合計 :deadlineCount 件の通知を行いました。'
        ]
    ]
];
