<?php

use yii\db\Migration;

/**
 * Class m201005_142009_create_table_contact
 */
class m201005_142010_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('books', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger(),
            'phone' => $this->string()->notNull(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string(),
            'image' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('books_user_id_index', 'books', 'user_id', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('books');
    }
}
