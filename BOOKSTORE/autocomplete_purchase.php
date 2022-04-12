<?php
	require_once 'login.php';
	
	$q=$_GET['q'];
	
	//build query
	$query = "SELECT * FROM buyer WHERE name_buyer LIKE '%$q%'";
	//Execute query
	$qry_result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
		if (!empty($qry_result))
		{
			while($row = mysqli_fetch_array($qry_result))
			{
				echo $row['name_buyer']."\n";
			}
		}
?>