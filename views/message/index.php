<?php

use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bariew\i18nModule\models\search\MessageSearch $searchModel
 */
echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute' => 'sourceCategory',
            'filter'    => \bariew\i18nModule\models\SourceMessage::categoryList(),
        ],
        [
            'attribute' => 'language',
            'filter'    => array_combine(\Yii::$app->i18n->getLanguages(), \Yii::$app->i18n->getLanguages()),
        ],
        'sourceMessage',
        'translation',
        [
            'attribute' => 'translationUpdate',
            'label'     => Yii::t('modules/i18n', 'Update'),
            'filter'    => [
                'is not null' => Yii::t('modules/i18n', 'Translated'),
                'is null'     => Yii::t('modules/i18n', 'Not translated'),
            ],
            'format' => 'raw',
            'value' => function($model) {
                $button = Yii::t('modules/i18n', 'Save');
                return
                    "<div class='input-group'>
                        <div contentEditable='true'
                            style='height:auto;min-height: 34px;'
                            id='{$model->id}-{$model->language}' "
                            . "class='form-control translate-live-input'>$model->translation</div>
                        <span class='input-group-btn'>
                           <button
                               type='button'
                               onclick='
                               $(this).parents(\"tr\").fadeOut();
                               $.post($(this).data(\"url\"), {
                                    translation : $(this).parent().prev().text(),
                                    _csrf : \"". Yii::$app->request->csrfToken."\"
                               })'
                               class='btn btn-default fast-translate'
                               data-id='{$model->id}-{$model->language}'
                               data-url='".Url::toRoute(['fast-update', 'id' => $model->id, 'language' => $model->language])."'
                           >{$button}</button>
                        </span>
                    </div>
                ";
            },
        ],
    ],
]);
