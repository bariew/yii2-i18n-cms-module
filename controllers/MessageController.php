<?php

namespace bariew\i18nModule\controllers;

use bariew\i18nModule\models\SourceMessage;
use Yii;
use bariew\i18nModule\models\Message;
use bariew\i18nModule\models\search\MessageSearch;
use yii\helpers\FileHelper;
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

    /**
     * Generates site translate sources, searching all app and modules files.
     */
    public function actionGenerateSource()
    {
        $messageController = new ConsoleController($this->id, $this->module);
        $languages = Yii::$app->i18n->languages;
        $paths = Yii::$app->i18n->getSourcePaths();
        $files = [];
        foreach ($paths as $path) {
            if (!$path || !file_exists($path) || is_file($path)) {
                continue;
            }
            $files = array_merge($files, FileHelper::findFiles(realpath($path)));
        }
        $messages = [];
        foreach ($files as $file) {
            $messages = array_merge_recursive($messages, $messageController->publicMethod('extractMessages', $file, 'Yii::t'));
        }

        $messageController->publicMethod('saveMessagesToDb',
            $messages,
            Yii::$app->db,
            SourceMessage::tableName(),
            Message::tableName(),
            true,
            $languages
        );
        Yii::$app->session->setFlash('success', Yii::t('modules/i18n', 'messages_imported'));
        $this->redirect(Yii::$app->request->referrer);
    }
}
