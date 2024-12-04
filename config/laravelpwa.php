<?php
return [
    'name' => 'SportClubPro',
    'manifest' => [
        'name' => env('APP_NAME', 'SportClubPro'),
        'short_name' => 'SportClubPro',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#0d9488',
        'display' => 'standalone',
        'orientation' => 'portrait',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/assets/favicon/manifest-icon-192.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/assets/favicon/manifest-icon-192.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/assets/favicon/manifest-icon-192.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/assets/favicon/manifest-icon-192.png',
                'purpose' => 'any maskable'
            ],
            '152x152' => [
                'path' => '/assets/favicon/manifest-icon-192.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/assets/favicon/manifest-icon-192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/assets/favicon/manifest-icon-512.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/assets/favicon/manifest-icon-512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/assets/splash/apple-splash-640-1136.png',
            '750x1334' => '/assets/splash/apple-splash-750-1334.png',
            '828x1792' => '/assets/splash/apple-splash-828-1792.png',
            '1125x2436' => '/assets/splash/apple-splash-1125-2436.png',
            '1170x2532' => '/assets/splash/apple-splash-1170-2532.png',
            '1179x2556' => '/assets/splash/apple-splash-1179-2556.png',
            '1206x2622' => '/assets/splash/apple-splash-1206-2622.png',
            '1242x2208' => '/assets/splash/apple-splash-1242-2208.png',
            '1242x2688' => '/assets/splash/apple-splash-1242-2688.png',
            '1284x2778' => '/assets/splash/apple-splash-1284-2778.png',
            '1290x2796' => '/assets/splash/apple-splash-1290-2796.png',
            '1320x2868' => '/assets/splash/apple-splash-1320-2868.png',
            '1488x2266' => '/assets/splash/apple-splash-1488-2266.png',
            '1536x2048' => '/assets/splash/apple-splash-1536-2048.png',
            '1620x2160' => '/assets/splash/apple-splash-1620-2160.png',
            '1640x2360' => '/assets/splash/apple-splash-1640-2360.png',
            '1668x2224' => '/assets/splash/apple-splash-1668-2224.png',
            '1668x2388' => '/assets/splash/apple-splash-1668-2388.png',
            '2048x2732' => '/assets/splash/apple-splash-2048-2732.png'
        ],
        'shortcuts' => [
            [
                'name' => 'Dashboard',
                'description' => 'Accesează dashboard-ul clubului',
                'url' => '/dashboard',
                'icons' => [
                    "src" => "/assets/favicon/manifest-icon-192.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Membri',
                'description' => 'Gestionează membrii clubului',
                'url' => '/members',
                'icons' => [
                    "src" => "/assets/favicon/manifest-icon-192.png",
                    "purpose" => "any"
                ]
            ]
        ],
        'screenshots' => [
            [
                'src' => '/assets/screenshots/desktop.jpg',
                'sizes' => '1280x720',
                'type' => 'image/jpeg',
                'form_factor' => 'wide',
                'label' => 'SportClubPro pe Desktop'
            ],
            [
                'src' => '/assets/screenshots/mobile.jpg',
                'sizes' => '750x1334',
                'type' => 'image/jpeg',
                'form_factor' => 'narrow',
                'label' => 'SportClubPro pe Mobil'
            ]
        ],
        'custom' => [
            'description' => 'Platformă gratuită pentru managementul cluburilor sportive',
            'categories' => ['business', 'productivity'],
            'lang' => 'ro',
            'prefer_related_applications' => false,
            'related_applications' => [],
            'protocol_handlers' => [],
            'scope' => '/',
            'iarc_rating_id' => '',
            'dir' => 'ltr'
        ]
    ]
];