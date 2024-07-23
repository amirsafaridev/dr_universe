<?php

return [
    'name' => 'DR universe',
    'manifest' => [
        'name' => 'DR universe',
        'short_name' => 'DR universe',
        'start_url' => 'https://ip100.ir',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'fullscreen',
        'orientation'=> 'portrait',
        'status_bar'=> 'black',
        'icons' => [
            '512x512' => [
                'path' => '/assets/img/logo2.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/assets/img/logo.png',
            '750x1334' => '/assets/img/logo.png',
            '828x1792' => '/iassets/img/logo.png',
            '1125x2436' => '/assets/img/logo.png',
            '1242x2208' => '/assets/img/logo.png',
            '1242x2688' => '/assets/img/logo.png',
            '1536x2048' => '/assets/img/logo.png',
            '1668x2224' => '/assets/img/logo.png',
            '1668x2388' => '/assets/img/logo.png',
            '2048x2732' => '/assets/img/logo.png',
        ],
        'shortcuts' => [
            [
                'name' => 'DR universe home page',
                'description' => 'DR universe home page',
                'url' => 'https://ip100.ir',
                'icons' => [
                    "src" => "/assets/img/logo.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/profile'
            ]
        ],
        'custom' => []
    ]
];
