<?php

class m141215_233256_add_round_score extends CDbMigration
{
	public function up()
	{
    	$this->execute("ALTER TABLE `user` ADD `round_points` INT(10)  NOT NULL  DEFAULT '0'  AFTER `round_order`;");
	}

	public function down()
	{
		$this->dropColumn('user', 'round_points');
		return true;
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