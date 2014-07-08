<?php
/**
 * Language selection widget view file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
echo  \yii\helpers\Html::dropDownList(
    'lang',
    \Yii::$app->language,
    \bariew\i18nModule\models\MessageLanguage::listAll(), [
        'class'     => 'form-control',
        'onchange' => 'window.location.href = "/i18n/message-language/change?value="+this.options[this.selectedIndex].value;'
    ]
);
