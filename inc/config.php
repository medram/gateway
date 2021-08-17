<?php

return [
	'DB' => [
		'HOSTNAME' 	=> getenv('DATABASE_HOST'),
		'DB_NAME' 	=> getenv('MYSQL_DATABASE'),
		'DB_USER'	=> getenv('MYSQL_USER'),
		'DB_PASS'	=> getenv('MYSQL_PASSWORD')
	],
	// if the project is at the root, just use "/"
	'projectFolder'	=> (getenv('SUB_DIRECTORY') === '' ? '/' : getenv('SUB_DIRECTORY')),
];

?>
