<?php

use yii\helpers\Html;
use Yii;


/* @var $this yii\web\View */
/* @var $model bariew\i18nModule\models\MessageLanguage */

$this->title = Yii::t('modules/i18n', 'Create {modelClass}', [
    'modelClass' => 'Message Language',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/i18n', 'Message Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-language-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
