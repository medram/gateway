<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{{TITLE}}</title>
		<style type="text/css">
			*, ::after, ::before {
				box-sizing: border-box;
				padding: 0;
				margin: 0;
			}

			body {
				font-family: arial, sans-serif;
				font-size: 14px;
				color: #444;
				line-height: 22px;
			}

			h1, h2, h3, h4, h5, h6 {
				display: block;
				padding: 3px 0px;
				margin-bottom: 5px;
				font-weight: lighter;
			}

			a {
				color: #967ADC;
				text-decoration: underline;
			}

			a:hover {
				color: #AC92EC;
			}

			#header {
				font-size: 20px;
				color: #FFF;
				background-color: #8CC152;
				padding: 20px;
			}

			#footer {
				font-size: 20px;
				color: #FFF;
				background-color: #8CC152;
				padding: 20px;
			}

			.section {
				padding: 40px 20px;
				background-color: #F5F5F5;
			}

			.container {
				width: 600px;
				max-width: 800px;
				margin: 0px auto;
			}

			/*------------- Custom buttons ----------------*/
			.btn {
				color: #FFF;
				padding: 5px 10px;
				margin-right: 3px;
				margin-bottom: 5px;
				border-radius: 3px;
				display: inline-block;
				text-align: center;
				text-decoration: none;
				cursor: pointer;
				outline: none;
			}

			.btn:hover {
				color: #FFF;
			}

			.btn:active {
				box-shadow: inset 0px 1px 4px rgba(0, 0, 0, 0.3);
			}

			.btn.btn-primary {
				background-color: #4A89DC;
			}

			.btn.btn-primary:hover {
				background-color: #5D9CEC;
			}

			.btn.btn-success {
				background-color: #8CC152;
			}

			.btn.btn-success:hover {
				background-color: #A0D468;
			}

			.btn.btn-danger {
				background-color: #DA4453;
			}

			.btn.btn-danger:hover {
				background-color: #ED5565;
			}

			.btn.btn-warning {
				background-color: #F6BB42;
			}

			.btn.btn-warning:hover {
				background-color: #FFCE54;
			}

			.btn.btn-lg {
				font-size: 18px;
				padding: 10px 20px;
			}

			.btn.btn-sm {
				font-size: 10px;
				padding: 1px 6px;
			}

			/*------------- Text directions ----------------*/
			.text-center {
				text-align: center;
			}
			
			.text-left {
				text-align: left;
			}

			.text-right {
				text-align: right;
			}
		</style>
	</head>
	<body>
		<div class="container">
		<div id="header" class="text-center">
			<span>{{SITE_NAME}}</span>
		</div>
