<?php
namespace bariew\i18nModule\components;

class I18NUrlManager extends \yii\web\UrlManager
{
    public function createUrl($params)
    {
        $lang = $this->getLang($params);
        $url = parent::createUrl($params);
        if (!$lang || ($lang == \Yii::$app->i18n->default)) {
            return $url;
        }
        $url = preg_replace(['/^\/'.$lang.'/', '/^\/'.\Yii::$app->language.'/'], ['', ''], $url);
        return '/' . $lang . $url;
    }

    protected $_lang;
    public function getLang($params)
    {
        if ($this->_lang) {
            return $this->_lang;
        }
        if (isset($params['lang'])) {
            return $this->_lang = $params['lang'];
        }
        $request = \Yii::$app->urlManager->parseRequest(\Yii::$app->request);
        if (isset($request[1]['lang'])) {
            return $this->_lang = $request[1]['lang'];
        }
        return false;
    }

    public function setLang($lang)
    {
        $this->_lang = $lang;
    }
}