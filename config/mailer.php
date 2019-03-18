<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    //'viewPath' => '',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.mailgun.org',
        'username' => 'postmaster@briefing.today',
        'password' => '_Water1983',
        'port' => '465',
        'encryption' => 'ssl',
        'streamOptions' => [
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]
    ],
    'messageConfig'=>[
        'charset'=>'UTF-8',
    ],
    'viewPath' => '@app/views/mail',
];