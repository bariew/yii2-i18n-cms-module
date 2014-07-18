<?php

namespace bariew\i18nModule\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceMessage $source
 */
class Message extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['translation', 'sourceMessage', 'sourceCategory'], 'string'],
            [['language', 'translation'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('modules/i18n', 'id'),
            'language'       => Yii::t('modules/i18n', 'language'),
            'sourceMessage'  => Yii::t('modules/i18n', 'message_source'),
            'sourceCategory' => Yii::t('modules/i18n', 'message_category'),
            'translation'    => Yii::t('modules/i18n', 'translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }

    /**
     * Возвращает сообщение для перевода из связанной модели.
     *
     * @return string
     */
    public function getSourceMessage()
    {
        return $this->source->message;
    }

    /**
     * Возвращает категорию перевода из связанной модели.
     *
     * @return string
     */
    public function getSourceCategory()
    {
        return $this->source->category;
    }

}
