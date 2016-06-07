<?php
/**
 * MessageSearch class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class MessageSearch extends Message
{
    public $sourceMessage;
    public $sourceCategory;
    public $translationUpdate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'translation', 'sourceMessage', 'sourceCategory'], 'string'],
            [['translationUpdate'], 'safe'],

        ];
    }

    /**
     * Default index search method
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Message::find();
        $query->joinWith('source');
        
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $dataProvider->getSort()->attributes['sourceMessage'] = [
            'asc' => ['source.message' => SORT_ASC],
            'desc' => ['source.message' => SORT_DESC],
        ];
        $dataProvider->getSort()->attributes['sourceCategory'] = [
            'asc' => ['source.category' => SORT_ASC],
            'desc' => ['source.category' => SORT_DESC],
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
            $query->andFilterWhere(['like', 'source.message', $this->sourceMessage]);
        }

        if ($this->language) {
            $query->andWhere(['language' => $this->language]);
        }
        
        if ($this->sourceCategory) {
            $query->andFilterWhere(['like', 'source.category', $this->sourceCategory]);
        }
        return $dataProvider;
    }
}
