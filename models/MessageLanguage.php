<?php
/**
 * MessageLanguage class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Stores all selected languages in database.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 * @property integer $id
 * @property string $title
 */
class MessageLanguage extends ActiveRecord
{
    const WIDGET_SCENARIO = 'widget';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{message_language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 2],
            [['title'], 'unique', 'except' => self::WIDGET_SCENARIO]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/i18n', 'ID'),
            'title' => Yii::t('modules/i18n', 'Title'),
        ];
    }

    protected static $_langList;
    /**
     * Lists all set languages.
     * @return array all languages title=>translation list.
     */
    public static function listAll()
    {
        if (self::$_langList) {
            return self::$_langList;
        }
        $languages = array_flip(self::find()->select('title')->column());
        return self::$_langList = array_intersect_key(self::listAllPossible(), $languages);
    }

    /**
     * Returns list af all languages by key => title.
     * @return array languages.
     */
    public static function listAllPossible()
    {
        return require __DIR__ . DIRECTORY_SEPARATOR . '_languageList.php';
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->cloneSources();
        }
    }

    public function cloneSources()
    {
        if (!$items = SourceMessage::find()->select('id')->column()) {
            return;
        }
        array_walk($items, function(&$v) {$v = [$v, $this->title]; });
        Yii::$app->db->createCommand()
            ->batchInsert(Message::tableName(), ['id','language'], $items)
            ->execute();
    }

    public function afterDelete()
    {
        Message::deleteAll(['language' => $this->title]);
    }
}
