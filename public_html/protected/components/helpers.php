<?php 
    function euro_strtotime($str)
    {
        return strtotime(str_replace('/', '-', $str));
    }

    if(!function_exists('str_putcsv'))
    {
        function str_putcsv($input, $delimiter = ',', $enclosure = '"')
        {
            // Open a memory "file" for read/write...
            $fp = fopen('php://temp', 'r+');
            // ... write the $input array to the "file" using fputcsv()...
            fputcsv($fp, $input, $delimiter, $enclosure);
            // ... rewind the "file" so we can read what we just wrote...
            rewind($fp);
            // ... read the entire line into a variable...
            $data = fread($fp, 1048576);
            // ... close the "file"...
            fclose($fp);
            // ... and return the $data to the caller, with the trailing newline from fgets() removed.
            return rtrim($data, "\n");
        }
    }
	
	function nl2p($string, $data = array())
	{
		return '<p>' . preg_replace('@(\r?\n){2,}@m', '</p><p>', $string) . '</p>';
	}
	
	function sendEmail($subject, $body, $recipients, $from = 'info@clpe.co.uk', $bcc = null)
	{
		sendPHPEmail($subject, $body, $recipients, $from, $bcc);
	}
	
	function sendPHPEmail($subject, $body, $recipients, $from, $bcc = null)
	{
		$headers = 'From: ' . $from . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
        if($bcc !== null)
        {
            $headers .= "\r\n" . 'Bcc: ' . $bcc;
        }
		
		foreach((array)$recipients as $recipient)
		{
			if(is_object($recipient)) // We're being provided with User objects
			{
				$to_address = $recipient->email_address;
				if(trim($recipient->first_name) || trim($recipient->last_name))
				{
					$to_address = $recipient->first_name . " " . $recipient->last_name . " <" . $recipient->email_address . ">";
				}
			}
			else // We're being provided with an email address or an array of email addresses
			{
				$to_address = $recipient;
			}
			mail($to_address, $subject, $body, $headers);
		}
	}
	
	function sendAmazonEmail($subject, $body, $recipients)
	{
		Yii::import('application.lib.*');
		require_once('ses.php');
		
		$ses = new SimpleEmailService('AKIAJSBFQPLLKU4FH2UA', 'bQFB/5K7rLAWN2c01YlUil9h4uJGhs4h+xCBD9DZ');
		
		foreach((array)$recipients as $recipient)
		{
			if(is_object($recipient)) // We're being provided with User objects
			{
				$to_address = $recipient->email_address;
				if(trim($recipient->first_name) || trim($recipient->last_name))
				{
					$to_address = $recipient->first_name . " " . $recipient->last_name . " <" . $recipient->email_address . ">";
				}
			}
			else // We're being provided with an email address or an array of email addresses
			{
				$to_address = $recipient;
			}
			
			$m = new SimpleEmailServiceMessage();
			
			//$m->addTo($to_address);
			$m->addTo("matt@pageplay.com");
			
			$m->setFrom('PagePlay <help@pageplay.com>');
			$m->setSubject($subject . " " . $to_address);
			$m->setMessageFromString($body);
			
			//print_r($ses->sendEmail($m));
			$ses->sendEmail($m);
		}
	}
	
	function getUploadPath()
	{
		$root_folder = Yii::getPathOfAlias('webroot');
		
		$date_folder = date("Ym");
		$from_root = '/uploads/' . $date_folder;
		
		$full_path = $root_folder . "/" . $from_root;
		
		if(!is_dir($full_path))
		{
			mkdir($full_path);
			chmod($full_path, 0755); 
		}
		
		return $from_root;
	}
?>