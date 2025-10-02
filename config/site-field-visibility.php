<?php

return [
    'sites' => [
        'groupe_blachere' => [
            'hidden_fields' => ['marie_blachere_builder'],
            'visible_fields' => ['page_builder'],
        ],
        'marie_blachere' => [
            'hidden_fields' => [],
            'visible_fields' => ['marie_blachere_builder', 'page_builder'],
        ],
    ],
];
