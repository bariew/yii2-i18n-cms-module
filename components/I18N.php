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
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class I18N extends CommonI18N
{
    public $default;

    public $_sourcePaths = [];

    public function init()
    {
        parent::init();
        if (!Yii::$app instanceof Application) {
            return false;
        }
        if (!Yii::$app->db->isActive || !Yii::$app->db->getTableSchema(SourceMessage::tableName())) {
            return false;
        }
        $urlConfig = [
            'class' => I18NUrlManager::className(),
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
        ];
        foreach(['baseUrl', 'cache', 'hostInfo','routeParam', 'ruleConfig', 'suffix', 'rules'] as $param)  {
            $urlConfig[$param] = \Yii::$app->urlManager->$param;
        }
        \Yii::configure(\Yii::$app, ['components' => ['urlManager' => $urlConfig]]);
        \Yii::$app->urlManager->addRules([
            '<lang:\w{2}>/<_a>'=>'site/<_a>',
            '<lang:\w{2}>/<_c>/<_a>'=>'<_c>/<_a>',
            '<lang:\w{2}>/<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
            '<lang:\w{2}>\W{0,1}' => 'site/index',
        ], false);

        $this->setLanguage();
    }

    public function getLanguages()
    {
        return MessageLanguage::listAll();
    }

    public function setLanguage()
    {
        $this->default = \Yii::$app->language;
        if ($lang = \Yii::$app->request->get('lang')) {
            \Yii::$app->language = $lang;
        }
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

    public function getWidget()
    {
        return LangSelect::widget();
    }
}