<?php

class m141114_185711_add_questions_table extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `question` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(11) unsigned NOT NULL,
          `text` varchar(255) NOT NULL DEFAULT '',
          `value` int(11) unsigned NOT NULL DEFAULT '1',
          `list_order` int(11) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		$this->dropTable('question');
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