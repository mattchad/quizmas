<?php

class m141205_214043_add_ordering_fields extends CDbMigration
{
	public function up()
	{
    	$this->execute("ALTER TABLE `user` ADD `round_order` INT(2)  UNSIGNED  NOT NULL  DEFAULT '1'  AFTER `photo_file`;");
    	$this->execute("ALTER TABLE `question` ADD `complete` INT(1)  UNSIGNED  NOT NULL  DEFAULT '0'  AFTER `list_order`;");
	}

	public function down()
	{
		$this->dropColumn('user', 'round_order');
		$this->dropColumn('question', 'complete');
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