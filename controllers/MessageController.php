<?php
/**
 * MessageController class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\controllers;

use Yii;
use bariew\i18nModule\models\Message;
use bariew\i18nModule\models\search\MessageSearch;
use yii\web\Controller;

/**
 * Manages site translation from admin area.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class MessageController extends Controller
{
    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    /**
     * Быстрое обновление перевода.
     *
     * @param int $id
     * @param string $language
     * @return string
     */
    public function actionFastUpdate($id, $language)
    {
        Message::updateAll(
            ['translation' => Yii::$app->request->post('translation')],
            compact('id', 'language')
        );
    }
}
