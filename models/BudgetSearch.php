<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Budget;

/**
 * BudgetSearch represents the model behind the search form of `app\models\Budget`.
 */
class BudgetSearch extends Budget
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['budget_id', 'project_id', 'task_id'], 'integer'],
            [['amount', 'spent', 'remaining'], 'number'],
            [['description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Budget::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'budget_id' => $this->budget_id,
            'project_id' => $this->project_id,
            'task_id' => $this->task_id,
            'amount' => $this->amount,
            'spent' => $this->spent,
            'remaining' => $this->remaining,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
