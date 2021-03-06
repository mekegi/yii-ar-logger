<?php

class m130723_113552_ar_logger_models extends CDbMigration
{
    const TABLE = 'log_session';
	public function up()
	{
        $this->createTable(self::TABLE, [
                'id_' . self::TABLE => 'pk',
                'created_at' => 'timestamp NULL DEFAULT CURRENT_TIMESTAMP',
                'fk_user' => 'integer',
                'action' => 'string',
                'controller' => 'string',
                'url' => 'string',
            ]
            ,'ENGINE=InnoDb' // remove this line if you dont use Mysql
        );

        $this->addForeignKey(
            'fk_user_log_session',
            self::TABLE,
            'fk_user',
            'user',
            'id',
            'SET NULL'
        );
	}

	public function down()
	{
        $this->dropTable(self::TABLE);
	}
}