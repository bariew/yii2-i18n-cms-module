<?php
/**
 * LangSelect class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\widgets;

use bariew\i18nModule\models\MessageLanguage;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Dropdown for language selection.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class LangSelect extends Widget
{
    /**
     * @var string view file name.
     */
    public $view = 'langSelect';

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!\Yii::$app->has('db')) {
            return;
        }
        $langs = \Yii::$app->i18n->getLanguages();
        if ($lang = \Yii::$app->request->post('lang')) {
            unset($_GET['q']);
            $get = \Yii::$app->request->get();
            \Yii::$app->urlManager->setLang($lang);
            \Yii::$app->controller->redirect(array_merge([\Yii::$app->request->baseUrl], $get));
        }
        return $this->render($this->view, ['langs' => array_combine($langs, $langs)]);
    }
}