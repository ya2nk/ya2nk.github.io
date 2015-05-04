<?php
class Request
{
	
	static function get($index,$filter,$default='')
	{
		if (isset($_GET[$index]))
		{
			return static::filter($_GET[$index],$filter);
		}
		else
		{
			return $default;
		}
	}
	
	static function post($index,$filter,$default='')
	{
		if (isset($_POST[$index]))
		{
			return static::filter($_POST[$index],$filter);
		}
		else
		{
			return $default;
		}
	}
	
	static function filter($var,$filter)
	{
		if ($filter == 'int')
		{
			return preg_replace('/[^0-9-]/', '', $var);
		}
			
		else if ($filter == 'float')
		{
			return preg_replace('/[^0-9-.]/', '', $var);
		}
		
		else if ($filter == 'string')
		{
			return strip_tags(preg_replace('/\'/','',$var));
		}
		
		else if ($filter == 'date')
		{
			if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$var))
			{
				return $var;
				
			}else{
				return date('Y-m-d',strtotime($var));
			}
		}
		else if ($filter == 'upper')
		{
			return strtoupper(static::filter($var,'string'));
		}
		
		else if ($filter == 'lower')
		{
			return strtolower(static::filter($var,'string'));
		}
		
		else if ($filter == null)
		{
			return $var;
		}
	}
	
	static function ip_address()
	{
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else
		{
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}
	
	static function encrypt($text)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5('tetran'), $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    static function decrypt($text)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5('tetran'), base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }
	
}