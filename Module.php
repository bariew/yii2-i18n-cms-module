<?php
/**
 * Module class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule;

use yii\i18n\I18N;

/**
 * Module for site-wide translations.
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class Module extends \yii\base\Module
{
    /**
     * This is for default modules menu items
     * @var array
     */
    public $params = [
        'menu'  => [
            'label'    => 'Settings',
            'items' => [
                [
                    'label' => 'Translations', 'url' => ['/i18n/message/index'],
                ],
            ]
        ],
    ];

    /**
     * This is module uninstalling callback
     */
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
