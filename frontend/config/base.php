<?php
return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'urlManagerBackend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'http://119.93.221.58:82',
            'hostInfo' => 'http://119.93.221.58:82',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            ],
        'cache' => require(__DIR__ . '/_cache.php'),
    ],
];
