<?php
/**
 * @var yii\web\View $this
 * @var bariew\i18nModule\models\Message $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class='input-group'>
    <div contentEditable='true'
         style='height:auto;min-height: 34px;'
         id='{$model->id}-{$model->language}'
         class='form-control translate-live-input'
         onkeydown='if (event.ctrlKey && event.keyCode == 13) $(this).next().find("button").click();',
        >
        <?= $model->translation ?>
    </div>
    <span class='input-group-btn'>
        <?= \yii\helpers\Html::button(Yii::t('modules/i18n', 'Save'), [
            'class' => 'btn btn-default fast-translate',
            'data-id'=>"{$model->id}-{$model->language}",
            'data-url'=>\yii\helpers\Url::toRoute(['fast-update', 'id' => $model->id, 'language' => $model->language]),
            'onclick' => "
               $(this).parents('tr').fadeOut();
               $.post($(this).data('url'), {
                    translation : $(this).parent().prev().text(),
                    _csrf : '".Yii::$app->request->csrfToken."'
               })"
        ]) ?>
    </span>
</div>