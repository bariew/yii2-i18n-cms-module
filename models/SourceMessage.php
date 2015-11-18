<?php
/**
 * SourceMessage class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;


/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message $translateMessage
 */
class SourceMessage extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('modules/i18n', 'ID'),
            'category'   => Yii::t('modules/i18n', 'Category'),
            'message'    => Yii::t('modules/i18n', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'id']);
    }
    /**
     * Gets all used categories list.
     * @return array source category list
     */
    public static function categoryList()
    {
        $data = self::find()->orderBy('category')->groupBy(['category'])->select(['category'])->column();
        return array_combine($data, $data);
    }

}
