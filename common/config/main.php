<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            // если оставить baseUrl пустым, тогда исчезную в URL /frontend/web/
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Hide index.php
            'showScriptName' => false,
            // Use pretty URLs
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'rules' => [
                ''          => 'site/index',
                'api/v1/<alias:.*>'    =>  'api/<alias>',
            ],
        ],
    ],
    'modules' => [
            'api' => [
                'class' => 'common\modules\api\Module',
            ],
        ],
];
