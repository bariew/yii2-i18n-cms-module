<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 06.06.16
 * Time: 14:47
 */

namespace bariew\i18nModule\behaviors;


use bariew\i18nModule\models\SourceMessage;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;

class ModelTranslateBehavior extends Behavior
{
    public $category = '{Class}_{attribute}';
    public $attributes = [];
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterSave',
        ];
    }

    /**
     * @var AfterSaveEvent $event
     */
    public function afterSave($event)
    {
        /** @var ActiveRecord $owner */
        $owner = $event->sender;
        foreach ($this->attributes as $attribute) {
            $category = str_replace(['{Class}', '{attribute}'], [strtolower($owner->formName()), $attribute], $this->category);
            $condition = ['category' => $category, 'message' => static::getOldAttribute($event, $attribute)];
            $data = ['category' => $category, 'message' => $owner->getAttribute($attribute)];
            switch ($event->name) {
                case ActiveRecord::EVENT_AFTER_INSERT :
                case ActiveRecord::EVENT_AFTER_UPDATE  :
                    $model = SourceMessage::findOne($condition) ? : new SourceMessage($data);
                    $model->save(false);
                    break;
                case ActiveRecord::EVENT_AFTER_DELETE :
                    SourceMessage::deleteAll($condition);
                    break;
            }
        }
    }

    public static function getOldAttribute($event, $attribute)
    {
        if (isset($event->changedAttributes) && isset($event->changedAttributes[$attribute])) {
            return $event->changedAttributes[$attribute];
        } else if(isset($event->sender->oldAttributes[$attribute])) {
            return $event->sender->oldAttributes[$attribute];
        } else {
            return $event->sender->{$attribute};
        }
    }
}