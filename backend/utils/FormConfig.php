<?php

return [
    'LicFisio' => [
        'fields' => ['Nombre', 'WhatsApp', 'Email'],
        'api_url' => $_ENV['INFILTRATION_URL']
    ],
    'puncion' => [
        'fields' => ['Nombre', 'WhatsApp'],
        'api_url' => $_ENV['PUNCION_URL']
    ],
    'form3' => [
        'fields' => ['UserName', 'PhoneNumber'],
        'api_url' => 'https://anotherapi.com/submit-data'
    ]
];

?>