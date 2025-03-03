<?php

namespace backend\controllers;

use common\models\EduDirection;
use common\models\StudentMaster;
use frontend\controllers\ActionTrait;
use common\models\Direction;
use common\models\DirectionCourse;
use common\models\ExamSubject;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\User;
use frontend\models\Contract;
use common\models\SerCreate;
use common\models\SerDel;
use frontend\models\StepFour;
use frontend\models\Test;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;


/**
 * Site controller
 */
class FileController extends Controller
{
    public $layout = 'cabinet';

    public function actionDirection()
    {
        $form_id = yii::$app->request->post('form_id');
        $lang_id = yii::$app->request->post('lang_id');
        $std_id = yii::$app->request->post('std_id');
        $student = Student::findOne(['id' => $std_id]);

        $directions = EduDirection::find()
            ->where([
                'edu_type_id' => $student->edu_type_id,
                'edu_form_id' => $form_id,
                'lang_id' => $lang_id,
                'status' => 1,
                'is_deleted' => 0
            ])->all();

        $options = "";
        $options .= "<option value=''>Yo'nalish tanlang ...<option>";
        if (count($directions) > 0) {
            foreach ($directions as $direction) {
                $eduDirection = $direction->direction;
                $options .= "<option value='$direction->id'>". $eduDirection->code ." - ". $eduDirection['name_uz']. "</option>";
            }
        }
        return $options;
    }


    public function actionDirectionCourse()
    {
        $dir_id = yii::$app->request->post('dir_id');
        $std_id = yii::$app->request->post('std_id');
        $student = Student::findOne(['id' => $std_id]);

        $direction = EduDirection::findOne([
            'edu_type_id' => $student->edu_type_id,
            'id' => $dir_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        $options = "";
        $options .= "<option value=''>Yakunlagan bosqichingiz ...<option>";

        if ($direction) {
            $directionCourses = DirectionCourse::find()
                ->where([
                    'edu_direction_id' => $direction->id,
                    'status' => 1,
                    'is_deleted' => 0
                ])->orderBy('course_id asc')->all();
            if (count($directionCourses) > 0) {
                foreach ($directionCourses as $course) {
                    $options .= "<option value='$course->id'>{$course->course['name_uz']}</option>";
                }
            }
        }

        return $options;
    }


    public function actionCreateSertificate($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = ExamSubject::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'edu_direction_id' => $student->edu_direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }


    public function actionDelSertificate($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = ExamSubject::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }


    public function actionDelOferta($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentOferta::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'edu_direction_id' => $student->edu_direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionDelTr($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentPerevot::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionCreateTr($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentPerevot::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'edu_direction_id' => $student->edu_direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }

    public function actionCreateOferta($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentOferta::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'edu_direction_id' => $student->edu_direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }

    public function actionDelDtm($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentDtm::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionCreateDtm($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentDtm::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }

    public function actionDelMaster($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentMaster::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'edu_direction_id' => $student->edu_direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionCreateMaster($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentMaster::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'edu_direction_id' => $student->edu_direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $query
            ]);
        }
    }

}
