<?php
/**
 * I18nBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\i18nModule;

use yii\base\BootstrapInterface;
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
        if (get_class($app) != Application::className()) {
            return true;
        };
        return true;
    }
}