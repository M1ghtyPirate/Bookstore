<?php
	require_once 'login.php';
	
	$tag = $_GET['tag'];
	
	$tag = mysqli_real_escape_string($link, $tag);
	
		//build query
	$query = "SELECT * FROM v_purchase WHERE name_buyer = '$tag'";
		//Execute query
	$qry_result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
		//Build Result String
	echo "<br /><table border=1>";
	echo "<tr>";
	echo "<th>ФИО</th>";
	echo "<th>Название книги</th>";
	echo "<th>Автор</th>";
	echo "<th>Стоимость</th>";
	echo "<th>Дата покупки</th>";
	echo "</tr>";
	
	while($row = mysqli_fetch_array($qry_result))
	{
		echo "<tr align='center'>";
		echo "<td>$row[name_buyer]</td>";
		echo "<td>$row[name_book]</td>";
		echo "<td>$row[author]</td>";
		echo "<td>$row[price]</td>";
		echo "<td>$row[date]</td>";
		echo "</tr>";
	}
	echo "</table><br />";
?>