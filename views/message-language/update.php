<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model bariew\i18nModule\models\MessageLanguage */

$this->title = Yii::t('modules/i18n', 'Update {modelClass}: ', [
    'modelClass' => 'Message Language',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/i18n', 'Message Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('modules/i18n', 'Update');
?>
<div class="message-language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
