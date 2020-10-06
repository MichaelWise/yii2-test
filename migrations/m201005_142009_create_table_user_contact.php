<?php

use yii\db\Migration;

/**
 * Class m201005_142009_create_table_contact
 */
class m201005_142009_create_table_user_contact extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('user_contacts', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger(),
            'phone' => $this->string()->notNull(),
            'username' => $this->string()->notNull(),
            'image' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('users_id_index', 'user_contacts', 'user_id', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('user_contact');
    }
}
