<?php
	class Hash 
	{
        /*
         * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
         * Copyright (c) 2013, Taylor Hornby
         * All rights reserved.
         *
         * Redistribution and use in source and binary forms, with or without 
         * modification, are permitted provided that the following conditions are met:
         *
         * 1. Redistributions of source code must retain the above copyright notice, 
         * this list of conditions and the following disclaimer.
         *
         * 2. Redistributions in binary form must reproduce the above copyright notice,
         * this list of conditions and the following disclaimer in the documentation 
         * and/or other materials provided with the distribution.
         *
         * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
         * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
         * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
         * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
         * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
         * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
         * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
         * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
         * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
         * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
         * POSSIBILITY OF SUCH DAMAGE.
         */
        
        // These constants may be changed without breaking existing hashes.
        const PBKDF2_HASH_ALGORITHM = 'sha256';
        const PBKDF2_ITERATIONS = 1000;
        const PBKDF2_SALT_BYTE_SIZE = 24;
        const PBKDF2_HASH_BYTE_SIZE = 24;
        
        const HASH_SECTIONS = 4;
        const HASH_ALGORITHM_INDEX = 0;
        const HASH_ITERATION_INDEX = 1;
        const HASH_SALT_INDEX = 2;
        const HASH_PBKDF2_INDEX = 3;
        const HASH_SIZE_INDEX = 3;
        const HASH_CIPHER_INDEX = 4;
        
        public static function create_hash($password)
        {
            // format: algorithm:iterations:salt:hash
            $salt = base64_encode(mcrypt_create_iv(Hash::PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
            return Hash::PBKDF2_HASH_ALGORITHM . ":" . Hash::PBKDF2_ITERATIONS . ":" .  $salt . ":" .
                base64_encode(Hash::pbkdf2(
                    Hash::PBKDF2_HASH_ALGORITHM,
                    $password,
                    $salt,
                    Hash::PBKDF2_ITERATIONS,
                    Hash::PBKDF2_HASH_BYTE_SIZE,
                    true
                ));
        }
        
        public static function random_key()
        {
            return sha1(mcrypt_create_iv(Hash::PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
        }
        
        public static function validate_password($password, $correct_hash)
        {
            $params = explode(":", $correct_hash);
            if(count($params) < Hash::HASH_SECTIONS)
               return false;
            $pbkdf2 = base64_decode($params[Hash::HASH_PBKDF2_INDEX]);
            return Hash::slow_equals(
                $pbkdf2,
                Hash::pbkdf2(
                    $params[Hash::HASH_ALGORITHM_INDEX],
                    $password,
                    $params[Hash::HASH_SALT_INDEX],
                    (int)$params[Hash::HASH_ITERATION_INDEX],
                    strlen($pbkdf2),
                    true
                )
            );
        }
        
        // Compares two strings $a and $b in length-constant time.
        public static function slow_equals($a, $b)
        {
            $diff = strlen($a) ^ strlen($b);
            for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
            {
                $diff |= ord($a[$i]) ^ ord($b[$i]);
            }
            return $diff === 0;
        }
        
        /*
         * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
         * $algorithm - The hash algorithm to use. Recommended: SHA256
         * $password - The password.
         * $salt - A salt that is unique to the password.
         * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
         * $key_length - The length of the derived key in bytes.
         * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
         * Returns: A $key_length-byte key derived from the password and salt.
         *
         * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
         *
         * This implementation of PBKDF2 was originally created by https://defuse.ca
         * With improvements by http://www.variations-of-shadow.com
         */
        public static function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
        {
            $algorithm = strtolower($algorithm);
            if(!in_array($algorithm, hash_algos(), true))
                trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
            if($count <= 0 || $key_length <= 0)
                trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
        
            if (function_exists("hash_pbkdf2")) {
                // The output length is in NIBBLES (4-bits) if $raw_output is false!
                if (!$raw_output) {
                    $key_length = $key_length * 2;
                }
                return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
            }
        
            $hash_length = strlen(hash($algorithm, "", true));
            $block_count = ceil($key_length / $hash_length);
        
            $output = "";
            for($i = 1; $i <= $block_count; $i++) {
                // $i encoded as 4 bytes, big endian.
                $last = $salt . pack("N", $i);
                // first iteration
                $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
                // perform the other $count - 1 iterations
                for ($j = 1; $j < $count; $j++) {
                    $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
                }
                $output .= $xorsum;
            }
        
            if($raw_output)
                return substr($output, 0, $key_length);
            else
                return bin2hex(substr($output, 0, $key_length));
        }
        
        public static function encrypt($text, $password)
        {
            // format: algorithm:iterations:salt:hash_size:ciphertext
            
        	# Prepend 4-chars data hash to the data itself for validation after decryption
            $text = substr(md5($text), 0, 4) . $text;
            
            //Calculate a random salt to use for the key
            $salt = base64_encode(mcrypt_create_iv(Hash::PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
            
            //Create a key based on default values above, our random salt and the given password.
            $key = base64_encode(Hash::pbkdf2(
                    Hash::PBKDF2_HASH_ALGORITHM,
                    $password,
                    $salt,
                    Hash::PBKDF2_ITERATIONS,
                    Hash::PBKDF2_HASH_BYTE_SIZE,
                    true
                ));
                            
            # create a random IV to use with CBC encoding
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            
            # creates a cipher text compatible with AES (Rijndael block size = 128)
            # to keep the text confidential 
            # only suitable for encoded input that never ends with value 00h
            # (because of default zero padding)
            $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_CBC, $iv);
        
            # prepend the IV for it to be available for decryption
            $ciphertext = $iv . $ciphertext;
        
            # encode the resulting cipher text so it can be represented by a string
            $ciphertext_base64 = base64_encode($ciphertext);
        
            return Hash::PBKDF2_HASH_ALGORITHM . ":" . Hash::PBKDF2_ITERATIONS . ":" .  $salt . ':' . Hash::PBKDF2_HASH_BYTE_SIZE . ':' . $ciphertext_base64;
        }
        
        public static function decrypt($correct_hash, $password)
        {
            $params = explode(":", $correct_hash);
            
            if(count($params) < Hash::HASH_SECTIONS)
               return false;
               
            $key = base64_encode(Hash::pbkdf2(
                    $params[Hash::HASH_ALGORITHM_INDEX],
                    $password,
                    $params[Hash::HASH_SALT_INDEX],
                    (int)$params[Hash::HASH_ITERATION_INDEX],
                    (int)$params[Hash::HASH_SIZE_INDEX],
                    true
                ));
                
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            
            $ciphertext_base64 = $params[Hash::HASH_CIPHER_INDEX];
            
            $ciphertext_dec = base64_decode($ciphertext_base64);
    
            # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
            $iv_dec = substr($ciphertext_dec, 0, $iv_size);
            
            # retrieves the cipher text (everything except the $iv_size in the front)
            $ciphertext_dec = substr($ciphertext_dec, $iv_size);
        
            # may remove 00h valued characters from end of plain text
            $plaintext_dec = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec), "\0");
            
            //Retrieve our 4 validation characters
            $validation_hash = substr($plaintext_dec, 0, 4);
            
            //Retrieve our original text, without the validation chars
            $original_text = substr($plaintext_dec, 4);
            
            //Calculate what the 4 validation characters should have been, based on our original text
            if (substr(md5($original_text), 0, 4) == $validation_hash)
            {
                //They match? Return the text then.
                return $original_text;
            }
            
            //Encryption failed. Return null to notify the code.
            return null;
        }
	}
?>