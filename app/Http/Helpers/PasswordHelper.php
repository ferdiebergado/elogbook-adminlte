<?php 

namespace App\Http\Helpers;

use App\Http\Controllers\EncryptionController;

trait PasswordHelper
{
	protected function decryptPassword(array $data)	
	{
		$keys = ['password', 'password_confirmation', 'old_password'];

		$passdata = [];

		foreach ($keys as $key) {

			if (array_key_exists($key, $data)) {

            	$passdata = array_merge($passdata,[
            		$key => EncryptionController::cryptoJsAesDecrypt(config('app.salt'), $data[$key])
            	]);
			}			

		}

        return array_replace($data, $passdata);		
	}
}