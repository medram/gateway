<?php

namespace MR4Web\Utils;

use MR4Web\Utils\View;

class Dashboard {

	private static $_dashboardPath = './dashboard/';

	public static function Render($content, array &$data)
	{
		$data['dash_content'] = View::render(self::$_dashboardPath.$content, $data, true);

		View::render(self::$_dashboardPath.'tpls/head', $data);
		View::render(self::$_dashboardPath.'tpls/body', $data);
		View::render(self::$_dashboardPath.'tpls/footer', $data);
	}
}

?>