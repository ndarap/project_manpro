<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'components' => [
        'request' => [
            'cookieValidationKey' => 'eNrkbvF1IenlYmyyA1sKyYlnM5XpO3Uj',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'db' => $db,

        // 🧾 Tambahan penting untuk mengatasi error currency dan locale
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'id-ID',            // 🌍 Format Indonesia
            'defaultTimeZone' => 'Asia/Jakarta',
            'currencyCode' => 'IDR',        // 💰 Default ke Rupiah
            'dateFormat' => 'php:d F Y',
            'datetimeFormat' => 'php:d F Y H:i',
            'timeFormat' => 'php:H:i',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
        ],

        // 🔧 Asset Manager: pastikan Krajee tidak memaksa Bootstrap 3
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'class' => 'yii\bootstrap5\BootstrapAsset',
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'class' => 'yii\bootstrap5\BootstrapPluginAsset',
                ],
                'kartik\base\BootstrapAsset' => [
                    'bsDependencyEnabled' => false, // Nonaktifkan dependency Bootstrap 3
                ],
            ],
        ],
    ],

    // ✅ Modul tambahan seperti GridView modern (Krajee)
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
            'bsVersion' => '5.x',
        ],
    ],

    // ✅ Parameter global
    'params' => array_merge($params, [
        'bsVersion' => '5.x', // agar Krajee tahu Bootstrap 5 dipakai
    ]),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
