<?php
/**
 * I18nBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\i18nModule;

use bariew\i18nModule\components\I18N;
use bariew\i18nModule\components\I18NUrlManager;
use yii\base\BootstrapInterface;
use yii\web\Controller;
use yii\base\Event;
use yii\console\Application;

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
        if (get_class($app) == Application::className()) {
            return;
        }
        \Yii::configure($app, ['components' => ['i18n' => [
            'class' => I18N::className(),
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'key',
                ],
            ],
        ]]]);

        $urlConfig = [
            'class' => I18NUrlManager::className(),
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
        ];
        foreach(['baseUrl', 'cache', 'hostInfo','routeParam', 'ruleConfig', 'suffix', 'rules'] as $param)  {
            $urlConfig[$param] = \Yii::$app->urlManager->$param;
        }
        \Yii::configure($app, ['components' => ['urlManager' => $urlConfig]]);
        \Yii::$app->urlManager->addRules([
            '<lang:\w{2}>/<_a>'=>'site/<_a>',
            '<lang:\w{2}>/<_c>/<_a>'=>'<_c>/<_a>',
            '<lang:\w{2}>/<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
            '<lang:\w{2}>\W{0,1}' => 'site/index',
        ], false);

        Event::on(Controller::className(), Controller::EVENT_BEFORE_ACTION, [\Yii::$app->i18n, 'setLanguage']);
        return true;
    }
}