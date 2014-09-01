<?php  
return [
    'menu'  => [
        'label'    => 'Settings',
        'items' => [
            [
                'label'    => 'i18n',
                'items' => [
                    ['label' => 'Languages', 'url' => ['/i18n/message-language/index']],
                    ['label' => 'Translations', 'url' => ['/i18n/message/index']],
                ]
            ],
        ]
    ],
];