<!DOCTYPE html>
<html>
	<head>
		<title>Учет продаж книг книжного магазина</title>
		<link rel="stylesheet" href="css/styles.css">
		<meta charset="UTF-8">
		
		<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
		
		<script type="text/javascript" src="js/script.js"></script>
		
		<script>
			$(document).ready(function(){
				$("#tag").autocomplete("autocomplete_purchase.php", {
					selectFirst: true
				});
			});
		</script>
	</head>
	<body>
		<?php
			require_once "menu.html";

		?>
		
		<div class="d_cont">
		
			<h2>Поиск проданных книг по ФИО покупателя</h2>
			
			<div id="page3">
				<br>
				<input name="tag" type="text" id='tag' size="20" onforminput='ajaxFunction2()'/>
				<input type="button" value="Найти" onClick='ajaxFunction2()'>
				
				<div id="ajaxDiv2"></div>
				
			</div>
		</div>
		
	</body>
</html>