<?php

namespace console\controllers;

use common\models\AuthAssignment;
use common\models\Direction;
use common\models\DirectionSubject;
use common\models\Drift;
use common\models\DriftCourse;
use common\models\DriftForm;
use common\models\Exam;
use common\models\ExamSubject;
use common\models\Message;
use common\models\Options;
use common\models\Questions;
use common\models\SendMessage;
use common\models\Std;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentGroup;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\User;
use Yii;
use yii\console\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\httpclient\Client;
use yii\web\Request;

class SettingController extends Controller
{

    public function actionIk0()
    {
        $text = 'Hurmatli abituriyent! \n\t\n Sizni “SARBON UNIVERSITETI”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To\'lov shartnomasini https://qabul.sarbon.university qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling! bizda o\'quv jarayonlari kunduzgi va kechki taʼlim shakli talabalari uchun 9-sentyabrdan, sirtqi taʼlim shakli talabalari uchun 16-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko\'chasi, 10-uy. \n Aloqa markazi: 78 888 22 88 \n So\'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university';
        $phone = '+998 (94) 505-52-50';
        Message::sendedSms($phone , $text);
    }

    public function actionIk1()
    {
        $students = Student::find()
            ->andWhere(['in' , 'id' , StudentPerevot::find()
                ->select('student_id')
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['<>' , 'file_status' , 3])
            ])->all();

        $text = 'Hurmatli abituriyent! \n\t\n Sizni “SARBON UNIVERSITETI”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To\'lov shartnomasini https://qabul.sarbon.university qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling! bizda o\'quv jarayonlari kunduzgi va kechki taʼlim shakli talabalari uchun 9-sentyabrdan, sirtqi taʼlim shakli talabalari uchun 16-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko\'chasi, 10-uy. \n Aloqa markazi: 78 888 22 88 \n So\'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university';

        if (count($students)) {
            $i = 0;
            foreach ($students as $student) {
                $phone = $student->username;
                Message::sendedSms($phone , $text);
                echo $i++."\n";
            }
        }
    }

    public function actionIk2()
    {
        $students = Student::find()
            ->andWhere(['in' , 'id' , StudentDtm::find()
                ->select('student_id')
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['<>' , 'file_status' , 3])
            ])->all();

        $text = 'Hurmatli abituriyent! \n\t\n Sizni “SARBON UNIVERSITETI”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To\'lov shartnomasini https://qabul.sarbon.university qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling! bizda o\'quv jarayonlari kunduzgi va kechki taʼlim shakli talabalari uchun 9-sentyabrdan, sirtqi taʼlim shakli talabalari uchun 16-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko\'chasi, 10-uy. \n Aloqa markazi: 78 888 22 88 \n So\'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university';

        if (count($students)) {
            $i = 0;
            foreach ($students as $student) {
                $phone = $student->username;
                Message::sendedSms($phone , $text);
                echo $i++."\n";
            }
        }
    }

    public function actionIk3()
    {
        $students = Student::find()
            ->andWhere(['in' , 'id' , Exam::find()
                ->select('student_id')
                ->andWhere(['is_deleted' => 0])
            ])->all();

        $text = 'Hurmatli abituriyent! \n\t\n Sizni “SARBON UNIVERSITETI”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To\'lov shartnomasini https://qabul.sarbon.university qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling! bizda o\'quv jarayonlari kunduzgi va kechki taʼlim shakli talabalari uchun 9-sentyabrdan, sirtqi taʼlim shakli talabalari uchun 16-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko\'chasi, 10-uy. \n Aloqa markazi: 78 888 22 88 \n So\'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university';

        if (count($students)) {
            $i = 0;
            foreach ($students as $student) {
                $phone = $student->username;
                Message::sendedSms($phone , $text);
                echo $i++."\n";
            }
        }
    }


    public function actionPhone()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $inputFileName = __DIR__ . '/excels/sms.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $bt = 0;
        foreach ($data as $key => $row) {
            if ($key != 0) {
                $phone = $row[0];

                $new = new SendMessage();
                $new->phone = $phone;
                $new->status = 0;
                $new->save(false);

                $bt++;
                echo $bt."\n";
            }
        }


        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi.";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }


    public function actionSendMessage()
    {
        $text2 = 'Hurmatli abituriyent! \n\t\n Siz Sarbon universitetiga hujjat topshirishni boshlab qo\'ydingiz. Lekin, yakuniga yetkazmadingiz. Arizani 15-oktabrga qadar https://qabul.sarbon.university tizimi orqali yakuniga yetkazing va ta\'lim shakli va yo\'nalishingizni tanlang.\n\t\n Muhim ma\'lumotlardan bexabar qolmaslik uchun universitet rasmiy telegram kanaliga obuna bo\'lishni unutmang: https://t.me/sarbonuniversity, \n Qabul: https://qabul.sarbon.university, \n Aloqa markazi: 78 888 22 88';

//        $text2 = 'Hurmatli abituriyent! \n\t\n Siz Sarbon universitetiga hujjat topshirdingiz. \n Muhim ma\'lumotlardan bexabar qolmaslik uchun universitet rasmiy telegram kanaliga obuna bo\'lishni unutmang: https://t.me/sarbonuniversity, \n Qabul: https://qabul.sarbon.university , \n Aloqa markazi: 78 888 22 88';

        $text1 = 'Hurmatli abituriyent! \n\t\n Toshkent shahrida yangi tashkil etilgan Sarbon universiteti oʻz faoliyatini boshladi. \n Qabul davom etmoqda. Quyida yoʻnalishlar bilan tanishing: \n https://telegra.ph/Bakalavriat-talim-yonalishlar-09-25 \n\t\n Qabul: https://qabul.sarbon.university \n Aloqa markazi: 78 888 22 88';

        $query = SendMessage::find()
            ->where(['status' => 0])
            ->all();
        foreach ($query as $item) {
            $phone = '+'.$item->phone;
            $result = Message::sendedSms($phone , $text1);
            if ($result == 'Request is received') {
                echo $item->id."\n";
                $item->status = 1;
                $item->push_time = time();
                $item->save(false);
            }
        }
    }

    public function actionDel()
    {
        $text1 = 'Hurmatli abituriyent! \n\t\n Toshkent shahrida yangi tashkil etilgan Sarbon universiteti oʻz faoliyatini boshladi. \n Qabul davom etmoqda. Quyida yoʻnalishlar bilan tanishing: \n https://telegra.ph/Bakalavriat-talim-yonalishlar-09-25 \n\t\n Qabul: https://qabul.sarbon.university \n Aloqa markazi: 78 888 22 88';

        $phone = '+998945055250';
        $result = Message::sendedSms($phone , $text1);
        if ($result == 'Request is received') {
            echo 121212;
        }
    }



    public function actionS1()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $inputFileName = __DIR__ . '/excels/10.10.2024 (2).xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

//        $direction = 'Psixologiya';
//        $text = 'Hurmatli abituriyent! \n\t\n Siz Sarbon unversiteti '.$direction.' yo\'nalishi talabasi bo\'lish imkoniyati bor! \n\t\n Imkoniyatni qo’ldan boy bermang! \n Quyidagi havola orqali ro‘yxatdan o‘ting. \n http://tashkent.sarbon.university \n\t\n Ma’lumot uchun: +998788882288';

        $text1 = 'Hurmatli abituriyent! \n\t\n Toshkent shahrida yangi tashkil etilgan Sarbon universiteti oʻz faoliyatini boshladi. \n Qabul davom etmoqda. Quyida yoʻnalishlar bilan tanishing: \n https://telegra.ph/Yonalishlar-10-12 \n\t\n Qabul: https://t.me/SarbonUzQabulBot \n Aloqa markazi: 99 232 80 20';

        $phone = '+998945055250';
        $result = Message::sendedSms($phone , $text1);

        dd($result);
//        $bt = 0;
//        foreach ($data as $key => $row) {
//            if ($row[0] > 0) {
//                $phone = $row[0];
//                $result = Message::sendedSms($phone , $text1);
//                $bt++;
//                echo $result." - ".$bt."\n";
//            } else {
//                break;
//            }
//        }


        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi.";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }


    public function actionS2() 
    {


        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $inputFileName = __DIR__ . '/excels/shartnomalar.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

//        $direction = 'Iqtisodiyot';
//        $text = 'Hurmatli abituriyent! \n\t\n Siz Sarbon unversiteti '.$direction.' yo\'nalishi talabasi bo\'lish imkoniyati bor! \n\t\n Imkoniyatni qo’ldan boy bermang! \n Quyidagi havola orqali ro‘yxatdan o‘ting. \n https://t.me/SarbonUzQabulBot \n\t\n Ma’lumot uchun: +998992328020';

//        $text = 'Hurmatli abituriyent! \n\t\n Sizni Sarbon universitetiga o\'qishga qabul qilinganingiz bilan yana bir bor tabriklaymiz. \n Joriy o’quv yilining kuzgi semestri darslari kunduzgi va kechki ta\'lim uchun 21- oktabrdan, sirtqi ta\'lim uchun 4-noyabrdan boshlanishini ma\'lum qilamiz. \n\t\n Batafsil ma\'lumot uchun: 78 888 22 88';


//        $text = 'Hurmatli abituriyent! \n\t\n Sizni Sarbon universitetiga o\'qishga qabul qilinganingiz bilan yana bir bor tabriklaymiz. \n\t\n Sirtqi ta\'lim darslari 4-noyabr soat 09:00 dan boshlanishini ma\'lum qilamiz va darsga o\'z vaqtida kelishingizni so\'raymiz! \n\t\n Manzil: Toshkent shahar, Olmazor tumani, Paxta MFY, Sag\'bon ko\'chasi, 290-uy';

//        $text = 'Sarbon universiteti haqida ma’lumot olish uchun quyidagi raqam bilan bog’lanishingizni iltimos qilamiz: \n +998992328020 \n +998884478020 \n\t\n Havola orqali ro’yxatdan to’liq o’ting! \n t.me/SarbonUzQabulBot';
            $text = 'Hurmatli abituriyent! \n\t\n Sizni Sarbon universitetiga o\'qishga qabul qilinganingiz bilan yana bir bor tabriklaymiz. \n\t\n Sirtqi ta\'lim darslari 4-noyabr soat 09:00 dan boshlanishini ma\'lum qilamiz va darsga o\'z vaqtida kelishingizni so\'raymiz! \n\t\n Zudlik bilan quyida raqamlarga aloqaga chiqing! Yoki quyidagi ko’rsatilgan manzilga kelishingizni so’raymiz. \n\t\n Manzil: Toshkent shahar, Olmazor tumani, Paxta MFY, Sag\'bon ko\'chasi, 290-uy \n\t\n Ma’lumot uchun: \n +998884478020 \n +998992328020';
//        $phone = '+998998351393';
//        $phone = '+998945055250';
//        $result = Message::sendedSms($phone , $text);
//
//        dd($result);


        $bt = 0;
        foreach ($data as $key => $row) {
            if ($key != 0) {
                $phone = $row[0];
                $result = Message::sendedSms($phone , $text);
                $bt++;
                echo $result." - ".$bt."\n";
            }
        }

        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi.";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }






    public function actionImport()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $inputFileName = __DIR__ . '/excels/adaAdAQ.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();


        $url = 'https://subsidiya.idm.uz/api/applicant/get-photo';

        $b = 0;
        foreach ($data as $key => $row) {
            if ($key != 0) {
                if ($row[0] == "") {
                    break;
                }
                $data = json_encode([
                    'pinfl' => $row[0]
                ]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode('ikbol:ikbol123321')
                ]);

                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                $photoBase64 = $response['data']['photo'] ?? null;

                if ($photoBase64) {
                    // Rasmni dekodlash
                    $photoData = base64_decode($photoBase64);

                    // Saqlash uchun fayl nomini va yo‘lini aniqlash
                    $fileName = $row[0].'__ik.jpg'; // Fayl nomini kerakli tarzda o'zgartirishingiz mumkin
                    $filePath = \Yii::getAlias('@console/controllers/excels/images/') . $fileName;

                    // Faylni papkaga saqlash
                    file_put_contents($filePath, $photoData);

                    echo $b++."\n";
                } else {
                    echo $row[0]."\n";
                }
            }
        }


        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi.";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }

}
