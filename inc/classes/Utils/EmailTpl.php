<?php

namespace MR4Web\Utils;

use MR4Web\Utils\View;

class EmailTpl {

	private static $_emailFolder = './emails_tpls/';

	public static function render($content, array &$data)
	{
		// set some necessary variables to the email tamplate.
		$data['SITE_NAME'] = getConfig('site_name');
		$data['SITE_EMAIL_SUPPORT'] = getConfig('email_support');
		$data['SITE_EMAIL_SALES'] = getConfig('email_sales_support');
		$data['FOOTER'] = '&copy; '.date('Y')." ".getConfig('site_name');

		$body = View::render(self::$_emailFolder.'tpls/header', $data, true);
		$body .= View::render(self::$_emailFolder.$content, $data, true);
		$body .= View::render(self::$_emailFolder.'tpls/footer', $data, true);

		foreach ($data as $key => $value)
		{
			$body = str_replace('{{'.$key.'}}', $value, $body);
		}
		return $body;
	}
}

?>