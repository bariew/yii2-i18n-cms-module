<?php

namespace bariew\i18nModule\components;
use yii\i18n\I18N as CommonI18N;

/**
 * MyClass class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class I18N extends CommonI18N
{
    public static $default = 'en';
    public $languages = ['en'];

    public $_sourcePaths = [];

    public static function setLanguage()
    {
        if (!$lang = \Yii::$app->request->get('lang')) {
            $lang = self::$default;
        }
        \Yii::$app->language = $lang;
        \Yii::$app->request->baseUrl = \Yii::$app->request->baseUrl . '/' .$lang;
    }

    public function getSourcePaths()
    {
        if ($this->_sourcePaths) {
            return $this->_sourcePaths;
        }
        $result = [
            \Yii::getAlias('@app/modules', false),
            \Yii::getAlias('@app/controllers', false),
            \Yii::getAlias('@app/models', false),
            \Yii::getAlias('@app/widgets', false),
            \Yii::getAlias('@app/components', false),
        ];
        foreach (\Yii::$app->modules as $module) {
            if (is_object($module)) {
                $result[] = $module->basePath;
            } else if (is_array($module) && isset($module['basePath'])) {
                $result[] = $module['basePath'];
            }
        }
        return $this->_sourcePaths = $result;
    }
}