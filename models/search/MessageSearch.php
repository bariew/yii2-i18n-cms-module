<?php

namespace bariew\i18nModule\models\search;

use bariew\i18nModule\models\SourceMessage;
use Yii;
use yii\data\ActiveDataProvider;
use bariew\i18nModule\models\Message;

/**
 * MessageSearch represents the model behind the search form about `bariew\i18nModule\models\Message`.
 */
class MessageSearch extends Message
{
    public $sourceMessage;
    public $sourceCategory;
    public $translationUpdate;
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'translation', 'sourceMessage', 'sourceCategory'], 'string'],
            [['translationUpdate'], 'safe'],

        ];
    }

    public function search($params)
    {
        $sourceMessageTable = SourceMessage::tableName();
        $query = Message::find();
        $query->joinWith('source');
        
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $dataProvider->getSort()->attributes['sourceMessage'] = [
            'asc' => [$sourceMessageTable.'.message' => SORT_ASC],
            'desc' => [$sourceMessageTable.'.message' => SORT_DESC],
        ];
        $dataProvider->getSort()->attributes['sourceCategory'] = [
            'asc' => [$sourceMessageTable.'.category' => SORT_ASC],
            'desc' => [$sourceMessageTable.'.category' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        if ($this->translation) {
            $t = addslashes($this->translation);
            $query->where("translation like '%{$t}%'");
        }

        if ($this->translationUpdate === 'is null') {
            $query->where('translation is null');
        }
        if ($this->translationUpdate === 'is not null') {
            $query->where('translation is not null');
        }

        if ($this->translation) {
            $query->andWhere(['like', 'translation', '%' . $this->translation .'%', false]);
        }
        if ($this->sourceMessage) {
            $query->andFilterWhere(['like', $sourceMessageTable.'.message', $this->sourceMessage]);
        }

        if ($this->language) {
            $query->andWhere(['language' => $this->language]);
        }
        
        if ($this->sourceCategory) {
            $query->andFilterWhere(['like', $sourceMessageTable.'.category', $this->sourceCategory]);
        }
        return $dataProvider;
    }
}
