<?php 

namespace App\Http\Helpers;

trait PasswordHelper
{
	use \App\Http\Helpers\CryptoJs;
	protected function decryptPassword(array $data)	
	{
		$keys = ['password', 'password_confirmation', 'old_password'];

		$passdata = [];

		foreach ($keys as $key) {

			if (array_key_exists($key, $data)) {

            	$passdata = array_merge($passdata,[
            		$key => $this->cryptoJsAesDecrypt(config('app.salt'), $data[$key])
            	]);
			}			

		}

        return array_replace($data, $passdata);		
	}
}