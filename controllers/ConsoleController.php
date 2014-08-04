<?php

namespace bariew\i18nModule\controllers;
use \yii\console\controllers\MessageController as ConsoleMessageController;
class ConsoleController extends ConsoleMessageController
{
    public function saveMessagesToDb($messages, $db, $sourceMessageTable, $messageTable, $removeUnused, $languages)
    {
        ob_start();
        return parent::saveMessagesToDb($messages, $db, $sourceMessageTable, $messageTable, $removeUnused, $languages);
    }

    public function extractMessages($fileName, $translator)
    {
        ob_start();
        return parent::extractMessages($fileName, $translator);
    }
}