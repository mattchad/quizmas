<?php 
    class Email
    {
        //Generic variables
        private $_delivery_method;
    	private $_from;
    	private $_to = array();
    	private $_cc = array();
    	private $_bcc = array();
    	private $_replyTo;
    	private $_subject;
    	private $_messagePlain;
    	private $_messageHtml;
    	private $_attachments = array();

        static $_mimeTypes = array('ai' => 'application/postscript', 'avi' => 'video/x-msvideo', 'doc' => 'application/msword', 'eps' => 'application/postscript', 'gif' => 'image/gif', 'htm' => 'text/html', 'html' => 'text/html', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'mov' => 'video/quicktime', 'mp3' => 'audio/mpeg', 'mpg' => 'video/mpeg', 'pdf' => 'application/pdf', 'ppt' => 'application/vnd.ms-powerpoint', 'ps' => 'application/postscript', 'rtf' => 'application/rtf', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'txt' => 'text/plain', 'xls' => 'application/vnd.ms-excel', 'csv' => 'text/comma-separated-values', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'flv' => 'video/x-flv', 'ics' => 'text/calendar', 'log' => 'text/plain', 'png' => 'image/png', 'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'psd' => 'image/photoshop', 'rm' => 'application/vnd.rn-realmedia', 'swf' => 'application/x-shockwave-flash', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'xml' => 'text/xml');
    	        
        public function __construct()
        {
            //Check that we've set a from address in our params
            if(!isset(Yii::app()->params->email_from_address))
            {
                trigger_error('From address not set for emails', E_USER_ERROR);
            }
            else
            {
                //We have a from address set in params, lets default to that. 
                $this->from(Yii::app()->params->email_from_address);
                
                //Additionally, do we have a from name too?
                if(isset(Yii::app()->params->email_from_name))
                {
                    //Yes, let's set the from address to include both name and email address. 
                    $this->from(Yii::app()->params->email_from_address, Yii::app()->params->email_from_name);
                }
            }
            
            //Set our delivery method, if we've supplied one in our Yii params
            if(isset(Yii::app()->params->email_delivery_method))
            {
                $this->_delivery_method = Yii::app()->params->email_delivery_method;
            }
        }
        
        public function &from($address, $name = null)
        {
            $this->_from = array('address'=>$address, 'name'=>$name);
            return $this;
        }
        
        public function &addTo($address, $name = null)
        {
            $this->_addRecipient('to', $address, $name);
            return $this;
        }
                
        public function &addCc($address, $name = null)
        {
            $this->_addRecipient('cc', $address, $name);
            return $this;
        }
        
        public function &addBcc($address, $name = null)
        {
            $this->_addRecipient('bcc', $address, $name);
            return $this;
        }
        
        public function &replyTo($address, $name = null)
    	{
    		if (!$this->_validateAddress($address))
    		{
    			throw new InvalidArgumentException("Reply To address \"{$address}\" is invalid");
    		}
    		
    		$this->_replyTo = array('address' => $address, 'name' => $name);
    		return $this;
    	}
    	
    	public function &addAttachment($filename, $options = array())
    	{
    		if (!is_file($filename))
    		{
    			throw new InvalidArgumentException("File \"{$filename}\" does not exist");
    		}
    		
    		$this->addStringAttachment(
    			isset($options['filenameAlias']) ? $options['filenameAlias'] : basename($filename),
    			file_get_contents($filename)
    		);
    		
    		return $this;
    	}
    	
    	public function &addStringAttachment($filename, $content)
    	{
    		$this->_attachments[$filename] = array(
    			'content' => $content,
    			'mimeType' => $this->_getMimeType($filename),
    		);
    		return $this;
    	}
    	
    	public function &subject($subject)
    	{
    		$this->_subject = $subject;
    		return $this;
    	}
    	
    	public function &messagePlain($message)
    	{
    		$this->_messagePlain = $message;
    		return $this;
    	}

    	public function &messageHtml($message)
    	{
    		$this->_messageHtml = $message;
    		return $this;
    	}
        
        private function _addRecipient($type, $address, $name = null)
    	{
    		if (!$this->_validateAddress($address))
    		{
    			throw new InvalidArgumentException("Address \"{$address}\" is invalid");
    		}
    		
    		$data = array('address' => $address, 'name' => $name);
    		
    		switch ($type)
    		{
    			case 'to':
    				$this->_to[] = $data;
    			break;
    			
    			case 'cc':
    				$this->_cc[] = $data;
    			break;
    			
    			case 'bcc':
    				$this->_bcc[] = $data;
    			break;
    		}
    	}
                
        public function send()
        {
            if(!strlen($this->_messageHtml))
            {
                if(!function_exists('nl2p'))
                {
                    function nl2p($string, $data = array())
                	{
                		return '<p>' . preg_replace('@((\r|\n)\n)+@m', '</p><p>', $string) . '</p>';
                	}
            	}
            	
            	$this->_messageHtml = nl2br(nl2p(strip_tags($this->_messagePlain)));
            	
            	$this->_messageHtml = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a href=\"$1\">$1</a>", $this->_messageHtml);
        	}

        	
            switch(strtolower($this->_delivery_method))
            {
                case 'postmark':
                {
                    $this->_sendPostmark();
                    
                    break;
                }
                default:
                {
                    //PHP Mail function
                    $this->_sendPHP();
            		
                    break;
                }
            }
            return true;
        }
        
        private function _sendPostmark()
        {
            //Specific code to translate this object into one that Postmark's class is happy with. 
                    
            if(Yii::app()->params->email_postmark_api_key === null)
            {
                trigger_error('Postmark API key is not set', E_USER_ERROR);
            }
            else
            {
                //No real reason to set these, except from keeping Postmark.php happy
                define('POSTMARKAPP_API_KEY', Yii::app()->params->email_postmark_api_key);
                define('POSTMARKAPP_MAIL_FROM_NAME', Yii::app()->params->email_from_name);
                define('POSTMARKAPP_MAIL_FROM_ADDRESS', Yii::app()->params->email_from_address);
            }
            
            //We've got everything we need, lets start setting the object up.
            Yii::import('application.extensions.Email.Postmark.Postmark');
            
            $email = new Postmark();
            
            $email->from($this->_from['address'], $this->_from['name']);
            
            foreach($this->_to as $recipient)
            {
                $email->addTo($recipient['address'], $recipient['name']);
            }
            
            foreach($this->_cc as $recipient)
            {
                $email->addCc($recipient['address'], $recipient['name']);
            }
            
            foreach($this->_bcc as $recipient)
            {
                $email->addBcc($recipient['address'], $recipient['name']);
            }
            
            if($this->_replyTo !== null)
            {
                $email->replyTo($this->_replyTo['address'], $this->_replyTo['name']);
            }
            
            $email->subject($this->_subject);
            
            $email->messagePlain($this->_messagePlain);
            
            if($this->_messageHtml !== null)
            {
                $email->messageHtml($this->_messageHtml);
            }
            
            foreach($this->_attachments as $filename => $attachment)
            {
                $email->addCustomAttachment($filename, $attachment['content'], $attachment['mimeType']);
            }
            
            $email->send();
        }
        
        private function _sendPHP()
        {
            $from = $this->_from['address'];
            if($this->_from['name'] !== null)
            {
                $from = $this->_from['name'] . ' <' . $this->_from['address'] . '>';
            }
            
            $to = array();
            foreach($this->_to as $recipient)
            {
                if($recipient['name'] !== null)
                {
                    $to[] = $recipient['name'] . ' <' . $recipient['address'] . '>';
                }
                else
                {
                    $to[] = $recipient['address'];
                }
            }
            
            $cc = array();
            foreach($this->_cc as $recipient)
            {
                if($recipient['name'] !== null)
                {
                    $cc[] = $recipient['name'] . ' <' . $recipient['address'] . '>';
                }
                else
                {
                    $cc[] = $recipient['address'];
                }
            }
            
            $bcc = array();
            foreach($this->_bcc as $recipient)
            {
                if($recipient['name'] !== null)
                {
                    $bcc[] = $recipient['name'] . ' <' . $recipient['address'] . '>';
                }
                else
                {
                    $bcc[] = $recipient['address'];
                }
            }
            
            //Reply to
            
            $headers = 'From: ' . $from . "\r\n" .
            			'X-Mailer: PHP/' . phpversion();
            			
            if($this->_replyTo !== null)
            {
                if($this->_replyTo['name'] !== null)
                {
                    $headers .= "\r\n" . 'Reply-To: ' . $this->_replyTo['name'] . ' <' . $this->_replyTo['address'] . '>';
                }
                else
                {
                    $headers .= "\r\n" . 'Reply-To: ' . $this->_replyTo['address'];
                }
            }
            
            if(sizeof($cc))
            {
                $headers .= "\r\n" . 'Cc: ' . implode(', ', $cc);
            }
            
            if(sizeof($bcc))
            {
                $headers .= "\r\n" . 'Bcc: ' . implode(', ', $bcc);
            }
            
    		echo mail(implode(', ', $to), $this->_subject, $this->_messagePlain, $headers);
        }
        
        private function _getMimeType($filename)
    	{
    		$extension = pathinfo($filename, PATHINFO_EXTENSION);
    		
    		if (isset(self::$_mimeTypes[$extension]))
    		{
    			return self::$_mimeTypes[$extension];
    			
    		} 
    		else if (function_exists('mime_content_type'))
    		{
    			 return mime_content_type($filename);
    		}
    		else if (function_exists('finfo_file'))
    		{
    			 $fh = finfo_open(FILEINFO_MIME);
    			 $mime = finfo_file($fh, $filename);
    			 finfo_close($fh);
    			 return $mime;
    		
    		}
    		else if ($image = getimagesize($filename))
    		{
    			return $image[2];
    		}
    		else
    		{
    			return 'application/octet-stream';
    		}
    	}
    	
    	private function _validateAddress($email)
    	{
    		// http://php.net/manual/en/function.filter-var.php
    		// return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    		// filter_var proved to be unworthy (passed foo..bar@domain.com as valid),
    		// and was therefore replace with
    		$regex = "/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i";
    		// from http://fightingforalostcause.net/misc/2006/compare-email-regex.php
    		return preg_match($regex, $email) === 1;
    	}
    }
?>