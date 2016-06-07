<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bariew\i18nModule\models\SourceMessage $model
 */
$this->title = Yii::t('modules/i18n', 'Create Translation Source');
?>
<h1><?= $this->title ?></h1>
<?php $form = \yii\widgets\ActiveForm::begin();  ?>
<?= $form->field($model, 'category')->textInput() ?>
<?= $form->field($model, 'message')->textInput() ?>
<div class="form-group well text-right">
    <?= \yii\helpers\Html::submitButton(Yii::t('modules/i18n', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php $form::end(); ?>