<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bariew\i18nModule\models\Message $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="ip-form">

    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => 30]) ?>
    <?= $form->field($model, 'translation')->textInput(['maxlength' => 30]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('modules/i18n', 'create')
                : Yii::t('modules/i18n', 'update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>