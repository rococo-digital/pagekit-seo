<?php

use Pagekit\Application;
use rococo\seo\Helper\TitleHelper;

return [
    'name' => 'rococo/seo',
    'type' => 'extension',
    'main' => function (Application $app) {
    },
    
    'autoload' => [
        'rococo\\seo\\' => 'src',
    ],
    
    'routes' => [],
    
    'widgets' => [],
    
    'menu' => [],
    
    'permissions' => [
        'seo: manage settings' => [
            'title' => 'Manage settings',
        ],
    ],
    
    'settings' => 'seo-settings',
    
    'resources' => [
        'rococo/seo:' => '',
    ],
    
    'config' => [
        'site_structure' => [
            'meta'  => ['description' => ['enabled' => true, 'use_og' => true]],
            'title' => [
                'enabled'           => false,
                'use_sitename'      => true,
                'use_path'          => false,
                'use_pagename'      => false,
                'use_og'            => true,
                'path_level'        => 0,
                'sitename_ordering' => 1,
                'path_ordering'     => 2,
                'pagename_ordering' => 3,
                'og_ordering'       => 4,
                'separator'         => ' | ',
            ],
        ],
    ],
    
    'events' => [
        'boot'         => function ($event, $app) {
        },
        'site'         => function ($event, $app) {
            $app->on('view.meta', function ($event, $meta) use ($app) {
                $titlehelper = new TitleHelper;
                
                if ($this->config('site_structure.meta.description.enabled')) {
                    $meta([
                        'description' => $meta->get('og:description'),
                    ]);
                }
                if ($this->config('site_structure.title.enabled')) {
                    $title = $titlehelper->generateTitle($meta);
                    if ($title) {
                        $meta->add('title', $title);
                    }
                }
            }, -150);
            
        },
        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('seo-settings',
                'rococo/seo:app/bundle/seo-settings.js', ['~extensions']);
        },
    ],
];