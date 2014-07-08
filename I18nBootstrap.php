<?php
/**
 * I18nBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\i18nModule;

use bariew\i18nModule\components\I18N;
use bariew\i18nModule\models\MessageLanguage;
use yii\base\BootstrapInterface;
use yii\base\Controller;
use yii\base\Event;

/**
 * Bootstrap class initiates message controller.
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class I18nBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        \Yii::configure($app, ['components' => ['i18n' => [
            'class' => I18N::className(),
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'key',
                ],
            ],
            'languages' => MessageLanguage::find()->select('title')->column()
        ]]]);

        \Yii::$app->urlManager->addRules([
            '<lang:\w{2}>/<module>/<controller>/<action>' => '<module>/<controller>/<action>',
            '<lang:\w{2}>/<controller>/<action>' => '<controller>/<action>',
            '<lang:\w{2}>\W{0,1}' => 'site/view',
        ], false);

        Event::on(Controller::className(), Controller::EVENT_BEFORE_ACTION, [\Yii::$app->i18n, 'setLanguage']);
        return true;
    }
}