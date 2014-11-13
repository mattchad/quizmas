<?php

class m141113_210306_amend_users extends CDbMigration
{
	public function up()
	{
    	$this->dropColumn('user', 'role');
    	$this->dropColumn('user', 'verified');
	}

	public function down()
	{
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}