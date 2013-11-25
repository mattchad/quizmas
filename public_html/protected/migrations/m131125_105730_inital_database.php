<?php

class m131125_105730_inital_database extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `user` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `first_name` varchar(50) NOT NULL,
		  `last_name` varchar(50) NOT NULL,
		  `email_address` varchar(150) NOT NULL DEFAULT '',
		  `password` varchar(255) NOT NULL DEFAULT '',
		  `hash` varchar(255) NOT NULL DEFAULT '',
		  `role` int(11) NOT NULL DEFAULT '0',
		  `verified` int(10) unsigned NOT NULL DEFAULT '0',
		  `points` int(10) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		
		$this->execute("INSERT INTO `user` (`id`, `first_name`, `last_name`, `email_address`, `password`, `hash`, `role`, `verified`, `points`)
		VALUES
			(1,'Matt','Chadwick','email1@email.com','','',30,1,0),
			(2,'Tom','Yates','email2@email.com','','',30,1,0),
			(3,'Rachael','Burns','email3@email.com','','',30,1,0),
			(4,'Harry','Bailey','email4@email.com','','',10,1,0),
			(5,'Chris','Charlton','email5@email.com','','',10,1,0),
			(6,'James','Gilbert','email6@email.com','','',10,1,0),
			(7,'Amy','Hart','email7@email.com','','',10,1,0),
			(8,'James','Galley','email8@email.com','','',10,1,0),
			(9,'Martin','Hicks','email9@email.com','','',10,1,0);");
	}

	public function down()
	{
		echo "m131125_105730_inital_database does not support migration down.\n";
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