<?php

class m130723_114204_ar_log_changes extends CDbMigration
{
	const TABLE = 'log_changes';
	public function up()
	{
        $this->createTable(self::TABLE, [
                'id_' . self::TABLE => 'pk',
                'created_at' => 'timestamp NULL DEFAULT CURRENT_TIMESTAMP',
                'fk_log_session' => 'integer',
                'fk_user' => 'integer',
                'generic_type' => 'string',
                'generic_id' => 'integer',
                'variable' => 'string',
                'old' => 'string',
                'new' => 'string',
                'title' => 'string',
                'add_info' => 'text',
            ],
            'ENGINE=InnoDb');

        $this->addForeignKey(
            'fk_user3443',
            self::TABLE,
            'fk_user',
            'user',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk_log_session4556',
            self::TABLE,
            'fk_log_session',
            'log_session',
            'id_log_session',
            'CASCADE'
        );

        $this->createIndex('variable1', self::TABLE, 'variable');
        $this->createIndex('generic123', self::TABLE, 'generic_type, generic_id');
	}

	public function down()
	{
        $this->dropTable(self::TABLE);
	}
}