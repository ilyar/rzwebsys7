<?php

use yii\db\Schema;

class m140529_191317_main_create_pages extends \app\modules\main\db\Migration
{

    public $tableName = "pages";

    public $permissionTable = "permission";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}", [
            'id' => Schema::TYPE_PK,
            'active' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'root' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'level' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'title' => Schema::TYPE_TEXT . ' NOT NULL',
            'code' => Schema::TYPE_TEXT . ' NOT NULL',
            'text' => Schema::TYPE_TEXT,
            'image' => Schema::TYPE_TEXT,
            'metatitle' => Schema::TYPE_TEXT,
            'keywords' => Schema::TYPE_TEXT,
            'description' => Schema::TYPE_TEXT,
            'comments' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
        ]);

        $this->insert("{{%$this->tableName}}", [

            'author_id' => 1,
            'root' => 1,
            'lft' => 1,
            'rgt' => 4,
            'level' => 1,
            'title' => '',
            'code' => ''
        ]);

        $this->insert("{{%$this->tableName}}", [

            'author_id' => 1,
            'root' => 1,
            'lft' => 2,
            'rgt' => 3,
            'level' => 2,
            'title' => 'Главная',
            'metatitle' => 'Главная',
            'code' => 'main',
            'text' => 'Главная страница',
        ]);

        $this->insertPermission('\app\modules\main\models\Pages');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

        $this->deletePermission('\app\modules\main\models\Pages');

    }
}
