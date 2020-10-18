<?php


namespace backend\controllers;

use backend\models\UserSearch;
use common\models\User;

class UserController extends Controller
{
    public $modelClass = User::class;
    public $searchModelClass = UserSearch::class;

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $users = new UserSearch();
        $dataProvider = $users->search([]);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $users]);
    }

}