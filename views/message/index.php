<?php
use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bariew\i18nModule\models\MessageSearch $searchModel
 */
$this->title = Yii::t('modules/i18n', "Translations");
?>
<h1>
<?= Html::encode($this->title) ?>
<?= Html::a(Yii::t('modules/i18n', 'Create Translation Source'), ['create'],
    ['class' => 'btn btn-success pull-right']) ?>
</h1>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute' => 'sourceCategory',
            'filter'    => \bariew\i18nModule\models\SourceMessage::categoryList(),
        ],
        [
            'attribute' => 'language',
            'filter'    => $searchModel::languageList(),
        ],
        'sourceMessage',
        [
            'attribute' => 'translation',
            'format' => 'raw',
            'value' => function($model) {
                return "<div contentEditable='true'
                    style='background-color: white;border: 1px solid #ddd;min-height: 20px'
                    class='form-control translate-live-input'
                >{$model->translation}</div>";
            }
        ],
        [
            'attribute' => 'translationUpdate',
            'label'     => Yii::t('modules/i18n', 'Update'),
            'filter'    => [
                'is not null' => Yii::t('modules/i18n', 'Translated'),
                'is null'     => Yii::t('modules/i18n', 'Not translated'),
            ],
            'format' => 'raw',
            'value' => function($model) {
                return \yii\helpers\Html::button("<i class='glyphicon glyphicon-ok'></i>", [
                    'class' => 'btn btn-success',
                    'data-id'=>"{$model->id}-{$model->language}",
                    'data-url'=>\yii\helpers\Url::toRoute(['fast-update', 'id' => $model->id]),
                    'onclick' => "
                           $(this).parents('tr').fadeOut();
                           $.post($(this).data('url'), {
                                translation : $(this).parents('tr').find('.translate-live-input').text(),
                                language : '".$model->language."',
                                _csrf : '".Yii::$app->request->csrfToken."'
                           })"
                ]) . ' '
                . \yii\helpers\Html::button("<i class='glyphicon glyphicon-remove'></i>", [
                    'class' => 'btn btn-danger class' . $model->id,
                    'data-id'=>"{$model->id}-{$model->language}",
                    'data-url'=>\yii\helpers\Url::toRoute(['delete', 'id' => $model->id]),
                    'onclick' => "
                           $('.btn-danger.class".$model->id."').parents('tr').fadeOut();
                           $.post($(this).data('url'), {_csrf : '".Yii::$app->request->csrfToken."'})"
                ]);
            },
        ],
    ],
]);
