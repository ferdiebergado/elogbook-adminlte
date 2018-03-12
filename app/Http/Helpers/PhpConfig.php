<?php
namespace App\Http\Helpers;
Trait PhpConfig 
{
	// Function to parse the content of phpinfo() to an array.
	// Source: http://php.net/manual/en/function.phpinfo.php
	// Credits: Joseph Reilly
	protected function quick_dev_insights_phpinfo() {
		ob_start();
		phpinfo(11);
		$phpinfo = array('phpinfo' => array());
		if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER)){
			foreach($matches as $match){
				if(strlen($match[1])){
					$phpinfo[$match[1]] = array();
				}elseif(isset($match[3])){
					$keys1 = array_keys($phpinfo);
					$phpinfo[end($keys1)][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
				}else{
					$keys1 = array_keys($phpinfo);
					$phpinfo[end($keys1)][] = $match[2];      
				}
			}
		}
		return $phpinfo;
	}	
}
