<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 *
 */
class StepThreeTwo extends Model
{
    const STEP = 4;

    public $filial_id;
    public $lang_id;
    public $edu_form_id;
    public $edu_type_id;
    public $edu_direction_id;
    public $direction_course_id;
    public $edu_name;
    public $edu_direction;

    public function rules()
    {
        return [
            // `edu_type_id` majburiy maydon
            [['filial_id' , 'lang_id' ,'edu_form_id' , 'edu_direction_id' , 'direction_course_id'], 'required'],

            // `edu_type_id` butun son bo'lishi kerak
            [['filial_id' , 'lang_id' ,'edu_form_id' , 'edu_direction_id' , 'direction_course_id'], 'integer'],

            [['edu_name' , 'edu_direction'], 'string' , 'max' => 255],

            [['filial_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Branch::class,
                'targetAttribute' => ['filial_id' => 'id'],
                'filter' => ['status' => 1, 'is_deleted' => 0],
                'message' => 'Tanlangan filial mavjud emas.'
            ],
            [['lang_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Lang::class,
                'targetAttribute' => ['lang_id' => 'id'],
                'filter' => ['status' => 1, 'is_deleted' => 0],
                'message' => 'Tanlangan filial mavjud emas.'
            ],
            [['edu_direction_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => EduDirection::class,
                'targetAttribute' => ['edu_direction_id' => 'id'],
                'filter' => [
                    'edu_form_id' => $this->edu_form_id,
                    'edu_type_id' => $this->edu_type_id,
                    'lang_id' => $this->lang_id,
                    'status' => 1,
                    'is_deleted' => 0,
                ],
                'message' => 'Tanlangan ta\'lim yo\'nalishi mavjud emas.'
            ],
            [['edu_form_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => EduForm::class,
                'targetAttribute' => ['edu_form_id' => 'id'],
                'filter' => ['status' => 1, 'is_deleted' => 0],
                'message' => 'Tanlangan ta\'lim shakli mavjud emas.'
            ],
            [['direction_course_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => DirectionCourse::class,
                'targetAttribute' => ['direction_course_id' => 'id'],
                'filter' => [
                    'edu_direction_id' => $this->edu_direction_id,
                    'status' => 1,
                    'is_deleted' => 0
                ],
                'message' => 'Tanlangan bosqich mavjud emas.'
            ],
        ];
    }

    public function getDirectionCourse()
    {
        return $this->hasOne(DirectionCourse::class, ['id' => 'direction_course_id']);
    }

    public function getEduDirection()
    {
        return $this->hasOne(EduDirection::class, ['id' => 'edu_direction_id']);
    }

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
            foreach ($lev1 as $key => $error) {
                $result[] = $error;
            }
        }
        return array_unique($result);
    }


    public function ikStep($user, $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$this->validate()) {
            return ['is_ok' => false, 'errors' => $this->simple_errors($this->errors)];
        }
        $student->setAttributes([
            'branch_id' => $this->filial_id,
            'edu_name' => $this->edu_name,
            'edu_direction' => $this->edu_direction,
        ]);

        if ($student->edu_direction_id != $this->edu_direction_id || $student->direction_course_id != $this->direction_course_id) {
            $eduDirection = EduDirection::findOne($this->edu_direction_id);
            $student->setAttributes([
                'lang_id' => $this->lang_id,
                'edu_form_id' => $this->edu_form_id,
                'edu_direction_id' => $this->edu_direction_id,
                'direction_id' => $eduDirection->direction_id,
                'direction_course_id' => $this->direction_course_id,
                'course_id' => $this->directionCourse->course_id,
            ]);

            $result = StepThree::createEduType($student);
            if (!$result['is_ok']) {
                $transaction->rollBack();
                return ['is_ok' => false , 'errors' => $errors];
            }
        }

        if (!$student->save(false)) {
            $errors[] = ['Student maʼlumotlarini yangilashda xatolik yuz berdi.'];
        }

        $user->step = self::STEP;
        if (!$user->save(false)) {
            $errors[] = ['Foydalanuvchi maʼlumotlarini yangilashda xatolik yuz berdi.'];
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }
        $transaction->rollBack();
        return ['is_ok' => false , 'errors' => $errors];
    }
}
