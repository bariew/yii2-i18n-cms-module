<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;


/* @var $this yii\web\View */
/* @var $model bariew\i18nModule\models\search\MessageLanguageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-language-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/i18n', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('modules/i18n', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
