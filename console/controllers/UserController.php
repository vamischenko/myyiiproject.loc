<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreate($username, $password, $name, $surname)
    {
        $model = new User;
        $model->username = $username;
        $model->setPassword($password);
        $model->name = $name;
        $model->surname = $surname;
        $model->role_id = User::ROLE_ADMIN;
        $model->status_id = User::STATUS_ACTIVE;
        if ($model->save()) {
            echo "Пользователь создан \r\n";
        } else {
            echo "Нужно без запятых \r\n";
        }
    }
}