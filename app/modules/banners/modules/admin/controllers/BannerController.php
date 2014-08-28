<?php

namespace app\modules\banners\modules\admin\controllers;

use Yii;
use app\modules\banners\models\Banner;
use common\controllers\Admin;
use yii\filters\VerbFilter;
use common\actions\crud;

/**
* BannerController implements the CRUD actions for Banner model.
*/
class BannerController extends Admin
{

    /**
    * @var string идентификатор файла перевода
    */
    public $tFile = "banners/app";

    /**
    * Поведения
    * @return array
    */
    public function behaviors()
    {
        $beh = parent::behaviors();

        $beh['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
                'groupdelete' => ['post'],
            ],
        ];

        return $beh;
    }

    /**
    * Действия
    * @return array
    */
    public function actions()
    {

        $class = Banner::className();

        return [

            'index'=>[
                'class'=>crud\Admin::className(),
                'modelClass'=>$class,
            ],
            'create'=>[
                'class'=>crud\Create::className(),
                'modelClass'=>$class,
            ],
            'update'=>[
                'class'=>crud\Update::className(),
                'modelClass'=>$class,
            ],

            'view'=>[
                'class'=>crud\View::className(),
                'modelClass'=>$class,
            ],

            'delete'=>[
                'class'=>crud\Delete::className(),
                'modelClass'=>$class,
            ],

            'groupdelete'=>[
                'class'=>crud\GroupDelete::className(),
                'modelClass'=>$class,
            ],

            'editable'=>[
                'class'=>crud\XEditable::className(),
                'modelClass'=>$class,
            ],

        ];

    }

}