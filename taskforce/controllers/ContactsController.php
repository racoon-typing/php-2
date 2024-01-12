<?php

namespace app\controllers;

use app\models\Contact;
use yii\web\Controller;

class ContactsController extends Controller {
    // public function actionIndex() {
    //     $contact = new Contact();

    //     $contact->name = "Петров Иван";
    //     $contact->phone = "79005552211";
    //     $contact->email = "petro.ivan@mail.ru";
    //     $contact->position = "Менеджер";

    //     $contact->save();
    //     return $this->render('index');
    // }

    // public function actionIndex()
    // {
    //     $contact = Contact::find()->one();
    //     if ($contact) {
    //         print($contact->name);
    //         print($contact->phone);
    //         print($contact->email);
    //         print($contact->position);
    //     }
    // }

    // public function actionIndex()
    // {
    //     $contacts = Contact::findAll(['position' => 'Менеджер']);
    //     foreach ($contacts as $contact) {
    //         print($contact->name);
    //     }
    // }

    // public function actionIndex()
    // {
    //     $props = [
    //         'name' => 'Титов Денис',
    //         'email' => 'den4ik@mail.ru',
    //         'phone' => '78006994521',
    //         'position' => 'Бухгалтер'
    //     ];
    //     $contact = new Contact();
    //     $contact->attributes = $props;
    //     $contact->save();
    // }

    public function actionIndex()
    {
        $contact = Contact::findOne(['email' => 'den4ik@mail.ru']);
        if ($contact) {
            $contact->phone = "79058889421";
            $contact->update();
        }
    }
}