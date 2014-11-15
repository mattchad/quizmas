<?php

class m141115_114821_amend_questions_for_encryption extends CDbMigration
{
	public function up()
	{
    	$this->execute("ALTER TABLE `question` CHANGE `text` `text` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL;");
        $this->execute("ALTER TABLE `question` ADD `encrypted` INT(1)  UNSIGNED  NOT NULL  DEFAULT '0'  AFTER `value`;");
	}

	public function down()
	{
    	$this->dropColumn('question', 'encrypted');
    	$this->execute("ALTER TABLE `question` CHANGE `text` `text` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT '';");
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