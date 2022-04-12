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
				$("#tag").autocomplete("autocomplete_book.php", {
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
		
			<h2>Поиск книг</h2>
			<form name="myForm">
			<select onChange="go(this);">
				<option selected disabled>Категории поиска</option>
				<option value="1">Поиск по жанру</option>
				<option value="2">Поиск по названию</option>
			</select>
			</form>
			
			<div id="page1" style="display:none">
				<form name="form1">
					<?php
						require_once 'login.php';
						$query = "SELECT * FROM genre";
						$sql = mysqli_query($link, $query);
						echo "<br>";
						echo "<select id='id_genre' onChange='ajaxFunction()'>\r\n";
						echo "<option selected disabled>Выберите жанр</option>";
						while($row = mysqli_fetch_array($sql))
						{
							$id_genre = intval($row['id_genre']);
							$name_genre = htmlspecialchars($row['name_genre']); // текст берется из поля name_genre
							echo "<option value=$id_genre>$name_genre</option>\r\n";
						}
						echo "</select>\r\n";
					?>
					
					<div id="ajaxDiv"></div>
				</form>
			</div>
			
			<div id="page2" style="display: none">
				<br>
				<input name="tag" type="text" id='tag' size="20" onforminput='ajaxFunction1()'/>
				<input type="button" value="Найти" onClick='ajaxFunction1()'>
				
				<div id="ajaxDiv1"></div>
				
			</div>
		</div>
		
	</body>
</html>