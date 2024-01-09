<?php

namespace frontend\controllers;

use taskforce\convertor\CsvSqlConverter;
use yii\web\Controller;

class ContactsController extends Controller {
    public function actionIndex() {
        $contactsImporter = new CsvSqlConverter("/tmp/contacts.csv", ['name', 'phone']);

        return $this->render('index');
    }
}