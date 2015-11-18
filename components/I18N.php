<?php
/**
 * I18N class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\components;

use bariew\i18nModule\models\SourceMessage;
use Yii;
use bariew\i18nModule\models\MessageLanguage;
use bariew\i18nModule\widgets\LangSelect;
use yii\i18n\I18N as CommonI18N;
use yii\web\Application;

/**
 * Extended yii I18N component for translations.
 * Sets language (from url get param).
 * Gets source paths for translate message sources collecting.
 * Gets language selection dropdown widget.
 *
 * @property array $languages
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class I18N extends CommonI18N
{
    public $default;
    public $configPath = '@app/config/i18n.php';
    public $languages = [];

    public $_sourcePaths = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!$this->languages) {
            $this->languages = $this->getConfig()['languages'];
        }
    }

    /**
     * Gets app config data
     * @return mixed
     */
    public function getConfig()
    {
        return require Yii::getAlias($this->configPath);
    }

    /**
     * Sets app language
     */
    public function setLanguage()
    {
        $this->default = \Yii::$app->language;
        if ($lang = \Yii::$app->request->get('lang')) {
            \Yii::$app->language = $lang;
        }
    }

    /**
     * Gets all app php files paths
     * @return array
     */
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

    /**
     * Gets language dropdown widget
     * @return string
     * @throws \Exception
     */
    public function getWidget()
    {
        return LangSelect::widget();
    }
}