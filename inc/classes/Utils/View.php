<?php

namespace MR4Web\Utils;

class View 
{
	public static function render($filename, array &$args = array(), $returnData = false) 
	{
		$path = VIEWS_DIR.$filename.'.php';
		$buffer = '';

		//echo $path;
		if (!file_exists($path))
		{
			exit("Error: The template view '{$filename}' not found in the views folder!");
			return false;
		}

		foreach ($args as $k => $v)
		{
			$$k = $v;
		}

		
		if (!$returnData)
			return include $path;
		else
		{
			ob_start();
			//echo "START BUFFER:<br>";
			include_once $path;
			//echo "END BUFFER<br>";
			$buffer = ob_get_contents();
			@ob_end_clean();
			
			return $buffer;
		}
	}
}

?>