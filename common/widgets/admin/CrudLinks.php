<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
/**
 * Class CrudLinks
 * Класс для отображения ссылок на CRUD действия
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class CrudLinks extends Widget {

    /**
     * Константы CRUD действий
     */

    const CRUD_LIST = "list";

    const CRUD_VIEW = "view";

    /**
     * @var string действие для которого отобразить кнопки (self::CRUD_LIST|self::CRUD_VIEW)
     */

    public $action;

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * Возвращает описание ссылок
     * @return array
     */

    public function getButtons() {

       return $buttons = [

            self::CRUD_LIST => [

                [
                    'label'=>Yii::t('core', 'Create'),
                    'url'=>['create'],
                    'options'=>['class' => 'btn btn-success'],
                    'permission'=>'createModel',
                ]

            ],

            self::CRUD_VIEW => [

                [
                    'label'=>Yii::t('core', 'Update'),
                    'url'=>['update', 'id' => $this->model->id],
                    'options'=>['class' => 'btn btn-primary'],
                    'permission'=>'updateModel',
                ],

                [
                    'label'=>Yii::t('core', 'Delete'),
                    'url'=>['delete', 'id' => $this->model->id],
                    'options'=>['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('core', 'Are you sure?'),
                            'method' => 'post',
                        ],
                    ],
                    'permission'=>'deleteModel',
                ],

            ],

        ];

    }

    /**
     * @inheritdoc
     */

    public function run() {

        $buttons = $this->getButtons()[$this->action];

        $html = '';

        foreach($buttons AS $button) {

            if(Yii::$app->user->can($button['permission'], ['model'=>$this->model]))
                $html .= Html::a($button["label"], $button["url"], $button["options"])."\n";

        }

        return $html;

    }

}