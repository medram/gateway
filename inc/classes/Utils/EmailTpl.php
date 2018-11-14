<?php

namespace MR4Web\Utils;

use MR4Web\Utils\View;

class EmailTpl {

	private static $_emailFolder = './emails_tpls/';

	public static function Render($content, array &$data)
	{
		$body = View::render(self::$_emailFolder.'tpls/header', $data, true);
		$body .= View::render(self::$_emailFolder.$content, $data, true);
		$body .= View::render(self::$_emailFolder.'tpls/footer', $data, true);
		return $body;
	}
}

?>