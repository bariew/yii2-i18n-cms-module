<?php
/**
 * Message class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
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
        return '{{%message}}';
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
            'id'             => Yii::t('modules/i18n', 'ID'),
            'language'       => Yii::t('modules/i18n', 'Language'),
            'sourceMessage'  => Yii::t('modules/i18n', 'Message source'),
            'sourceCategory' => Yii::t('modules/i18n', 'Message category'),
            'translation'    => Yii::t('modules/i18n', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id'])
            ->from(['source' => SourceMessage::tableName()]);
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

    /**
     * @return array
     */
    public static function languageList()
    {
        $config = require \Yii::getAlias('@app/config/i18n.php');
        return array_combine($config['languages'], $config['languages']);
    }

}
