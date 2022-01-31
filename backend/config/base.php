<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'http://119.93.221.58:81',
            'hostInfo' => 'http://119.93.221.58:81',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php')
    ],
];
