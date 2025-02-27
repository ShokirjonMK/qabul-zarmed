<?php

namespace common\models;

use common\models\AuthAssignment;
use common\models\Message;
use common\models\Student;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\httpclient\Client;

/**
 * Signup form
 */
class StepOne extends Model
{
    public $jshshr;

    public function rules()
    {
        return [
            [['jshshr'], 'required'],
            [['jshshr'], 'string', 'min' => 14, 'max' => 14, 'message' => 'Pasport pin 14 xonali bo\'lishi kerak'],
            [['jshshr'], 'match', 'pattern' => '/^\d{14}$/', 'message' => 'Pasport pin faqat 14 ta raqamdan iborat bo‘lishi kerak'],
        ];
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

    public function ikStep($user , $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $pinfl = $student->passport_pin;

        if (!$this->validate()) {
            $errors[] = $this->simple_errors($this->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        if ($pinfl != $this->jshshr) {

//            self::deleteNull($student->id);

            $client = new Client();
            $url = 'https://payme.z7.uz/ik/get-passport';

            $params = [
                'passport_pin' => $this->jshshr,
            ];

            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl($url)
                ->setData($params)
                ->addHeaders(['content-type' => 'application/json'])
                ->send();

            dd($response->data);

            if ($response->isOk) {
                $data = $response->data;
                dd($data);

                $student->first_name = $first_name;
                $student->last_name = $last_name;
                $student->middle_name = $middle_name;
                $student->passport_number = $number;
                $student->passport_serial = $seria;
                $student->passport_pin = $pin;

                $student->passport_issued_date = date("Y-m-d" , strtotime($b_date));
                $student->passport_given_date = date("Y-m-d" , strtotime($e_date));
                $student->passport_given_by = $given_by;
                $student->birthday = $birthday;
                $student->gender = $jins;
                if (!$student->validate()){
                    $errors[] = $this->simple_errors($student->errors);
                }
            } else {
                $errors[] = ['Ma\'lumotlarni olishda xatolik yuz berdi.'];
            }

        }

        $student->update(false);
//        $user->step = 2;
//        $user->update(false);

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }

        $transaction->rollBack();
        return ['is_ok' => false, 'errors' => $errors];
    }

    public static function deleteNull($studentId)
    {
        try {
            Student::updateAll([
                'edu_type_id' => null,
                'edu_form_id' => null,
                'direction_id' => null,
                'edu_direction_id' => null,
                'lang_id' => null,
                'direction_course_id' => null,
                'course_id' => null,
                'edu_name' => null,
                'edu_direction' => null,
                'exam_type' => 0,
                'branch_id' => null,
            ], ['id' => $studentId]);

            foreach (['common\models\Exam', 'common\models\ExamSubject','common\models\StudentDtm', 'common\models\StudentPerevot', 'common\models\StudentMaster', 'common\models\StudentOferta'] as $table) {
                if (class_exists($table)) {
                    call_user_func([$table, 'updateAll'], ['is_deleted' => 1], ['student_id' => $studentId, 'is_deleted' => 0]);
                }
            }
        } catch (\Exception $e) {
            Yii::error("deleteNull error: " . $e->getMessage());
        }
    }

}
