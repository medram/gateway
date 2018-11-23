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
				color: #444 !important;
				line-height: 22px;
				background-color: #EEE !important;
			}

			h1, h2, h3, h4, h5, h6 {
				display: block;
				padding: 3px 0px;
				margin-bottom: 5px;
				margin-top: 10px;
				font-weight: lighter;
			}

			a {
				color: #15c !important;
				text-decoration: underline;
			}

			a:hover {
				color: #3473e1 !important;
			}

			#header {
				font-size: 20px;
				color: #FFF;
				padding: 20px;
			}

			#footer {
				color: #FFF;
				padding: 20px;
			}

			.section {
				padding: 20px 25px;
				background-color: #FFF !important;
			}


			.container {
				width: 600px;
				max-width: 800px;
				margin: 0px auto;
			}

			/*------------- Custom background colors ----------------*/

			.bg-green {
				color: #FFF !important;
				background-color: #8CC152 !important;
			}

			.bg-blue {
				color: #FFF !important;
				background-color: #4A89DC !important;
			}

			.bg-red {
				color: #FFF !important;
				background-color: #DA4453 !important;
			}

			.bg-yellow {
				color: #FFF !important;
				background-color: #F6BB42 !important;
			}

			.bg-purple {
				color: #FFF !important;
				background-color: #967ADC !important;
			}

			.bg-info {
				color: #FFF;
				background-color: #3BAFDA !important;
			}

			/*------------- Custom buttons ----------------*/
			.btn {
				color: #FFF !important;
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
				color: #FFF !important;
			}

			.btn:active {
				box-shadow: inset 0px 1px 4px rgba(0, 0, 0, 0.3) !important;
			}

			.btn.btn-primary {
				background-color: #4A89DC !important;
			}

			.btn.btn-primary:hover {
				background-color: #5D9CEC !important;
			}

			.btn.btn-success {
				background-color: #8CC152 !important;
			}

			.btn.btn-success:hover {
				background-color: #A0D468 !important;
			}

			.btn.btn-danger {
				background-color: #DA4453 !important;
			}

			.btn.btn-danger:hover {
				background-color: #ED5565 !important;
			}

			.btn.btn-warning {
				background-color: #F6BB42 !important;
			}

			.btn.btn-warning:hover {
				background-color: #FFCE54 !important;
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
			.color-blue {
				color: #4A89DC !important;
			}
			
			.color-green {
				color: #8CC152 !important;
			}

			.color-red {
				color: #DA4453 !important;
			}

			.color-yellow {
				color: #F6BB42 !important;
			}

			.color-info {
				color: #3BAFDA !important;
			}

			.color-purple {
				color: #967ADC !important;
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

			.font-consolas {
				font-family: consolas;
			}

			/*------------- Custome border radius ----------------*/
			.radius-3x {
				border-radius: 3px;
			}

			.radius-5x {
				border-radius: 5px;
			}

			.radius-10x {
				border-radius: 10px;
			}

			.radius-15x {
				border-radius: 15px;
			}

			.radius-50p {
				border-radius: 50%;
			}			
			
			/*------------- Custome font sizes ----------------*/
			.font-sm {
				font-size: 12px;
			}
			.font-md {
				font-size: 15px;
			}
			.font-lg {
				font-size: 20px;
			}
			.font-super-lg {
				font-size: 30px;
			}

		</style>
	</head>
	<body>
		<div class="container">
		<div id="header" class="bg-green text-center">
			<span>{{SITE_NAME}}</span>
		</div>
