<?php

use Pagekit\Application;

return [
    'name' => 'spqr/seo',
    'type' => 'extension',
    'main' => function (Application $app) {
    },
    
    'autoload' => [
        'Spqr\\Seo\\' => 'src',
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
        'spqr/seo:' => '',
    ],
    
    'config' => [
        'site_structure' => [
            'meta'  => ['description' => ['enabled' => true, 'use_og' => true]],
            'title' => [
                'enabled'           => false,
                'use_og'            => true,
                'use_sitename'      => true,
                'use_pagename'      => false,
                'og_ordering'       => 1,
                'sitename_ordering' => 2,
                'pagename_ordering' => 3,
                'separator'         => '|',
            ],
        ],
    ],
    
    'events' => [
        'boot'         => function ($event, $app) {
        },
        'site'         => function ($event, $app) {
            $app->on('view.meta', function ($event, $meta) use ($app) {
                if ($this->config('site_structure.meta
                .description.enabled')
                ) {
                    $meta([
                        'description' => $meta->get('og:description'),
                    ]);
                }
                if ($this->config('site_structure.title.enabled')) {
                    
                    $title_data = [];
                    $title      = [];
                    
                    if ($this->config('site_structure.title.use_og')
                        && !empty($meta->get('og:title'))
                    ) {
                        $title_data[] = [
                            'title'    => $meta->get('og:title'),
                            'ordering' => $this->config('site_structure.title.og_ordering'),
                        ];
                    }
                    if ($this->config('site_structure.title.use_sitename')
                        && !empty($app::config('system/site')->get('title'))
                    ) {
                        $title_data[] = [
                            'title'    => $app::config('system/site')
                                ->get('title'),
                            'ordering' => $this->config('site_structure.title.sitename_ordering'),
                        ];
                    }
                    if ($this->config('site_structure.title.use_pagename')
                        && !empty($app::node()->title)
                    ) {
                        $title_data[] = [
                            'title'    => $app::node()->title,
                            'ordering' => $this->config('site_structure.title.pagename_ordering'),
                        ];
                    }
                    
                    $ordering = [];
                    
                    foreach ($title_data as $key => $row) {
                        $ordering[$key] = $row['ordering'];
                    }
                    
                    array_multisort($ordering, SORT_ASC, $title_data);
                    
                    foreach ($title_data as $t) {
                        $title[] = $t['title'];
                    }
                    
                    $title
                        = implode($this->config('site_structure.title.separator'),
                        $title);
                    
                    $meta->add('title', $title);
                }
            }, -150);
            
        },
        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('seo-settings',
                'spqr/seo:app/bundle/seo-settings.js', ['~extensions']);
        },
    ],
];