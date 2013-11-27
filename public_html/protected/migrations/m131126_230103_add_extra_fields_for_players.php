<?php

class m131126_230103_add_extra_fields_for_players extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `user` ADD `sound_file` VARCHAR(50)  NULL  DEFAULT NULL  AFTER `points`;");
		$this->execute("ALTER TABLE `user` ADD `photo_file` VARCHAR(50)  NULL  DEFAULT NULL  AFTER `sound_file`;");
		$this->execute("UPDATE user SET photo_file = 'photo-matt.png' WHERE id=1");
		$this->execute("UPDATE user SET photo_file = 'photo-tom.png' WHERE id=2");
		$this->execute("UPDATE user SET photo_file = 'photo-rachael.png' WHERE id=3");
		$this->execute("UPDATE user SET photo_file = 'photo-harry.png' WHERE id=4");
		$this->execute("UPDATE user SET photo_file = 'photo-chris.png' WHERE id=5");
		$this->execute("UPDATE user SET photo_file = 'photo-gilbert.png' WHERE id=6");
		$this->execute("UPDATE user SET photo_file = 'photo-amy.png' WHERE id=7");
		$this->execute("UPDATE user SET photo_file = 'photo-galley.png' WHERE id=8");
		$this->execute("UPDATE user SET photo_file = 'photo-martin.png' WHERE id=9");
		$this->execute("UPDATE user SET sound_file = 'buzzer-matt.ogg' WHERE id=1");
		$this->execute("UPDATE user SET sound_file = 'buzzer-tom.ogg' WHERE id=2");
		$this->execute("UPDATE user SET sound_file = 'buzzer-rachael.ogg' WHERE id=3");
		$this->execute("UPDATE user SET sound_file = 'buzzer-harry.ogg' WHERE id=4");
		$this->execute("UPDATE user SET sound_file = 'buzzer-chris.ogg' WHERE id=5");
		$this->execute("UPDATE user SET sound_file = 'buzzer-gilbert.ogg' WHERE id=6");
		$this->execute("UPDATE user SET sound_file = 'buzzer-amy.ogg' WHERE id=7");
		$this->execute("UPDATE user SET sound_file = 'buzzer-galley.ogg' WHERE id=8");
		$this->execute("UPDATE user SET sound_file = 'buzzer-martin.ogg' WHERE id=9");
	}

	public function down()
	{
		$this->dropColumn('user', 'sound_file');
		$this->dropColumn('user', 'photo_file');
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