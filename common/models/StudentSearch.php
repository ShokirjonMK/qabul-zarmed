<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Student;

/**
 * StudentSearch represents the model behind the search form of `common\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'gender', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'edu_type_id', 'edu_form_id', 'direction_id', 'edu_direction_id', 'lang_id', 'direction_course_id', 'course_id', 'exam_type'], 'integer'],
            [['first_name', 'last_name', 'middle_name', 'student_phone', 'username', 'password', 'birthday', 'passport_number', 'passport_serial', 'passport_pin', 'passport_issued_date', 'passport_given_date', 'passport_given_by', 'adress', 'edu_name', 'edu_direction'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Student::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'edu_type_id' => $this->edu_type_id,
            'edu_form_id' => $this->edu_form_id,
            'direction_id' => $this->direction_id,
            'edu_direction_id' => $this->edu_direction_id,
            'lang_id' => $this->lang_id,
            'direction_course_id' => $this->direction_course_id,
            'course_id' => $this->course_id,
            'exam_type' => $this->exam_type,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'student_phone', $this->student_phone])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_pin', $this->passport_pin])
            ->andFilterWhere(['like', 'passport_issued_date', $this->passport_issued_date])
            ->andFilterWhere(['like', 'passport_given_date', $this->passport_given_date])
            ->andFilterWhere(['like', 'passport_given_by', $this->passport_given_by])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'edu_name', $this->edu_name])
            ->andFilterWhere(['like', 'edu_direction', $this->edu_direction]);

        return $dataProvider;
    }
}
