<?php
	require_once 'login.php';
	
	$search = $_GET['search'];
	
	$search = mysqli_real_escape_string($link, $search);
	
		//build query
	$query = "SELECT * FROM book INNER JOIN genre ON book.id_genre = genre.id_genre WHERE book.id_genre = '$search'";
		//Execute query
	$qry_result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
		//Build Result String
	echo "<br /><table border=1>";
	echo "<tr>";
	echo "<th>Название</th>";
	echo "<th>Автор</th>";
	echo "<th>Количество страниц</th>";
	echo "<th>Год</th>";
	echo "<th>Издательство</th>";
	echo "<th>Стоимость</th>";
	echo "<th>Жанр</th>";
	echo "</tr>";
	
	while($row = mysqli_fetch_array($qry_result))
	{
		echo "<tr align='center'>";
		echo "<td>$row[name_book]</td>";
		echo "<td>$row[author]</td>";
		echo "<td>$row[pages]</td>";
		echo "<td>$row[year]</td>";
		echo "<td>$row[publisher]</td>";
		echo "<td>$row[price]</td>";
		echo "<td>$row[name_genre]</td>";
		echo "</tr>";
	}
	echo "</table><br />";
?>