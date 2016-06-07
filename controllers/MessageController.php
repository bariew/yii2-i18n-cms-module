<?php
/**
 * MessageController class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\controllers;

use bariew\i18nModule\models\SourceMessage;
use Yii;
use bariew\i18nModule\models\Message;
use bariew\i18nModule\models\MessageSearch;
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
     * Fast translation update.
     *
     * @param int $id
     * @return string
     */
    public function actionFastUpdate($id)
    {
        Message::updateAll(
            ['translation' => Yii::$app->request->post('translation')],
            ['id' => $id, 'language' => Yii::$app->request->post('language')]
        );
    }

    public function actionCreate()
    {
        $model = new SourceMessage();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('modules/i18n', 'Successfully saved.'));
            $this->redirect(['index']) && Yii::$app->end();
        }
        return $this->render('create', compact('model'));
    }

    /**
     * Deletes all source and translation messages.
     * @param $id
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        SourceMessage::findOne($id)->delete();
    }
}
