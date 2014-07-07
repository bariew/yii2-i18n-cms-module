<?php

namespace bariew\i18nModule\controllers;

use Yii;
use bariew\i18nModule\models\Message;
use bariew\i18nModule\models\search\MessageSearch;
use yii\web\Controller;


/**
 * TranslateController implements the CRUD actions for Message model.
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
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
        $model = Message::findOne(['id' => $id, 'language' => $language]);
        $model->translation = Yii::$app->request->post()['translation'];
        if ($model->save()) {
            return json_encode(['result' => true]);
        } else {
            return json_encode(['result' => false]);
        }
    }
}
