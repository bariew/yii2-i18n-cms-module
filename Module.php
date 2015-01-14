<?php

namespace bariew\i18nModule;
/**
 * Module class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
use yii\i18n\I18N;

/**
 * Module for site-wide translations.
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class Module extends \yii\base\Module
{
    public $params = [
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

    public function uninstall()
    {
        \Yii::configure(\Yii::$app, ['components' => ['i18n' => [
            'class' => I18N::className(),
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ]]]);
    }
}
