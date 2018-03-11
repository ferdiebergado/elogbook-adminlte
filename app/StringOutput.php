<?php 

namespace App;
use Symfony\Component\Console\Output\Output;

/**
*  Snippet from laravel-admin-extensions/helpers
*  Source: https://github.com/laravel-admin-extensions/helpers/blob/master/src/Controllers/TerminalController.php
* 
*/
class StringOutput extends Output
{
	public $output = '';
    public function clear()
    {
        $this->output = '';
    }
    protected function doWrite($message, $newline)
    {
        $this->output .= $message.($newline ? "\n" : '');
    }
	public function getContent()
	{
		return trim($this->output);
	}
}
