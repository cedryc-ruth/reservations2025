<?php

return [
    'feeds' => [
        'main' => [
            'items' => [App\Models\Show::class, 'getFeedItems'],
            'url' => '/rss',
            'title' => 'Derniers spectacles',
            'description' => 'Flux RSS des derniers spectacles',
            'language' => 'fr-FR',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => 'application/atom+xml',
        ],
    ],
];