<?php
/**
 * Language selection widget view file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
$form = \yii\widgets\ActiveForm::begin(['fieldConfig' =>[
    'class' => \yii\widgets\ActiveField::className(),
    'template'  => '{input}'
]]);
echo \yii\helpers\Html::dropDownList('lang', Yii::$app->language, $langs, [
    'class'     => 'form-control',
    'onchange' => '$(this).parents("form").submit();'
]);
$form::end();