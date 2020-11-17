<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%people}}`.
 */
class m201117_142221_create_people_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%people}}', [
            'id' => $this->primaryKey(),
            'category_id'=> $this->string(),
            'firstname'=> $this->string()->notNull(),
            'lastname'=> $this->string()->notNull(),
            'email'=> $this->string()->notNull(),
            'gender'=> $this->boolean(),
            'birthDate'=> $this->date()->notNull(),
        ]);

        $this->createIndex('category_id', '{{%people}}', 'category_id');
        $this->createIndex('gender', '{{%people}}', 'gender');
        $this->createIndex('birthDate', '{{%people}}', 'birthDate');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%people}}');
    }
}
