<?php
/**
 * MessageLanguage class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\models;

use Yii;

/**
 * Stores all selected languages in database.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 * @property integer $id
 * @property string $title
 */
class MessageLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 2],
            [['title'], 'unique']
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

    /**
     * Lists all set languages.
     * @return array all languages title=>translation list.
     */
    public static function listAll()
    {
        $languages = self::find()->select('title')->groupBy('title')->orderBy('title ASC')->column();
        $result = [];
        foreach ($languages as $language) {
            $result[$language] = Yii::t('modules/i18n', 'Language {language}', compact('language'));
        }
        return $result;
    }

    /**
     * Returns list af all languages by key => title.
     * @return array languages.
     */
    public static function listAllPossible()
    {
        return require __DIR__ . DIRECTORY_SEPARATOR . '_languageList.php';
    }
}
