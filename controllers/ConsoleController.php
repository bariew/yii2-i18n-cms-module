<?php

namespace bariew\i18nModule\controllers;
use \yii\console\controllers\MessageController;
class ConsoleController extends MessageController
{
    public function publicMethod($name, $a = null, $b = null, $c = null, $d = null, $e = null, $f = null)
    {
        return $this->$name($a, $b, $c, $d, $e, $f);
    }
}