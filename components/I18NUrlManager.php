<?php
/**
 * I18NUrlManager class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\components;

/**
 * Manages App urls adding language data
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class I18NUrlManager extends \yii\web\UrlManager
{
    /**
     * @var string language storage
     */
    protected $_lang;

    /**
     * Adds language into url
     * @param array|string $params
     * @return mixed|string
     */
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

    /**
     * Gets site's language
     * @param $params
     * @return bool
     */
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

    /**
     * Sets this language
     * @param $lang
     */
    public function setLang($lang)
    {
        $this->_lang = $lang;
    }
}