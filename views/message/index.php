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
            'filter'    => array_combine(\Yii::$app->i18n->languages, \Yii::$app->i18n->languages),
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
            'value' => function($model) { return Yii::$app->view->render('form', compact('model')); },
        ],
    ],
]);
