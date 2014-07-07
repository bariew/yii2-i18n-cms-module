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
            'sortLinkOptions'      => []
        ],
        [
            'attribute' => 'language',
            'filter'    => [
                'en' => Yii::t('modules/i18n', 'translate_grid_filter_english'),
                'ru' => Yii::t('modules/i18n', 'translate_grid_filter_russian'),
            ],
            'headerOptions' => [
                'width' => '115px',
            ],
        ],
        [
            'attribute' => 'sourceMessage',
            'headerOptions' => [
                'width' => '250px',
            ],
        ],
        [
            'attribute' => 'translation',
            'headerOptions' => [
                'width' => '250px',
            ],
        ],
        [
            'attribute' => 'translationUpdate',
            'label'     => Yii::t('modules/i18n', 'translate_grid_update_translate_field'),
            'filter'    => [
                'is not null' => Yii::t('modules/i18n', 'translate_grid_filter_translated_messages'),
                'is null'     => Yii::t('modules/i18n', 'translate_grid_filter_not_translated_messages'),
            ],
            'format' => 'raw',
            'value' => function($model) {
                    $button = Yii::t('modules/i18n', 'create_translation');
                    return "
                        <div class='input-group'>
                            <div contentEditable='true' 
                                id='{$model->id}-{$model->language}' "
                                . "class='form-control translate-live-input'>$model->translation</div>
                            <span class='input-group-btn'>
                               <button
                                   type='button'
                                   class='btn btn-default fast-translate'
                                   data-id='{$model->id}-{$model->language}'
                                   data-url='".Url::toRoute(['fast-update', 'id' => $model->id, 'language' => $model->language])."'
                               >
                                    $button
                               </button>
                            </span>
                        </div>
                    ";
                },
        ],
    ],
]);
