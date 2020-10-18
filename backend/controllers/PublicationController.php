<?php

namespace backend\controllers;

use backend\models\PublicationSearch;
use common\models\Publication;

class PublicationController extends Controller
{
    public $modelClass = Publication::class;
    public $searchModelClass = PublicationSearch::class;

}