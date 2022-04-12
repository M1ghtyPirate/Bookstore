<!DOCTYPE html>
<html>
	<head>
		<title>Учет продаж книг книжного магазина</title>
		<link rel="stylesheet" href="css/styles.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php
			require_once "menu.html";
			require_once 'login.php';
			
			if ( !isset( $_GET["action"] ) ) $_GET["action"] = "showlist";
			
			switch ( $_GET["action"] )
			{
				case "showlist":	// Список всех записей в таблице БД
					show_list($link); break;
				case "addform":		// Форма для добавления новой записи
					get_add_item_form(); break;
				case "add":			// Добавить новую запись в таблицу БД
					add_item(); break;
				case "editform":	// Форма для редактирования записи
					get_edit_item_form(); break;
				case "update":		// Обновить запись в таблице БД
					update_item(); break;
				case "delete":		// Удалить запись в таблице БД
					delete_item(); break;
				default:
					show_list($link);
			}
			
			// Функция выводит список всех записей в таблице БД
			function show_list($link)
			{
				global $link;
				$query = 'SELECT * FROM v_purchase';
				$res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link));
				echo '<div class="d_cont">';
				echo '<h2>Список проданных книг</h2>';
				echo '<button type="button" onClick="history.back();">Назад</button><br>';
				echo '<br><table border="1">';
				echo '<tr align="center"><th>ФИО</th><th>Название книги</th>
					<th>Автор</th><th>Стоимость</th><th>Дата покупки</th><th></th><th></th></tr>';
				while ( $item = mysqli_fetch_array( $res ) )
				{
					echo '<tr align="center" class="tb1">';
					echo '<td>'.$item['name_buyer'].'</td>';
					echo '<td>'.$item['name_book'].'</td>';
					echo '<td>'.$item['author'].'</td>';
					echo '<td>'.$item['price'].'</td>';
					echo '<td>'.$item['date'].'</td>';
					echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_purchase='.$item['id_purchase'].'"><img src="img/edit.png" title="Редактировать"></a</td>';
					echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_purchase='.$item['id_purchase'].'"><img src="img/drop.png" title="Удалить"></a></td>';
					echo '</tr>';
				}
				echo '<tr align="center">
					  <td colspan=7>
						<a href="'.$_SERVER['PHP_SELF'].'?action=addform"><button type="button">Добавить</button></a>
					  </td>
					  </tr>';
				echo '</table>';
				echo '</div>';
			}
			
			// Функция формирует форму для добавления записи в таблице БД
			function get_add_item_form()
			{
				global $link;
				echo '<div class="d_cont">';
				echo '<h2>Добавить</h2>';
				echo '<form name="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
				echo '<button type="button" onClick="history.back();">Отменить</button><br />';
				echo '<br><table border="1">';
				echo '<tr>';
				echo '<td>ФИО</td>';
				echo '<td>';
				$sql1 = "Select * FROM buyer";
				
				$res1 = mysqli_query($link, $sql1) or die( "Error in $sql1 : " . mysql_error());
				
				echo '<select name="id_buyer">\r\n';
				echo "<option selected disabled>Выберите покупателя</option>";
				while($row = mysqli_fetch_array($res1))
				{
					$id_buyer = intval($row['id_buyer']);
					$name_buyer = htmlspecialchars($row['name_buyer']);
					echo "<option value='$id_buyer'>$name_buyer</option>\r\n";
				}
				echo "</select>\r\n";
				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Название</td>';
				echo '<td>';
				$sql2 = "Select * FROM book";
				
				$res2 = mysqli_query($link, $sql2) or die( "Error in $sql2 : " . mysql_error());
				
				echo '<select name="id_book">\r\n';
				echo "<option selected disabled>Выберите книгу</option>";
				while($row = mysqli_fetch_array($res2))
				{
					$id_book = intval($row['id_book']);
					$name_book = htmlspecialchars($row['name_book']);
					echo "<option value='$id_book'>$name_book</option>\r\n";
				}
				echo "</select>\r\n";
				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Дата</td>';
				echo '<td><input type="text" name="date" value="" /></td>';
				echo '</tr>';
				echo '<tr align="center">';
				echo '<td colspan="2"><input type="submit" value="Сохранить"></td>';
				echo '</tr>';
				echo '</table>';
				echo '</form>';
				echo '</div>';
			}
			
			// Функция добавляет новую запись в таблицу БД
			function add_item()
			{
				global $link;
				$id_buyer = mysqli_escape_string( $link, $_POST['id_buyer'] );
				$id_book = mysqli_escape_string( $link, $_POST['id_book'] );
				$date = mysqli_escape_string( $link, $_POST['date'] );
				$query = "INSERT INTO purchase (id_buyer,id_book,date) VALUES ('".$id_buyer."','".$id_book."','".$date."');";
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу purchase.php
				echo '<meta http-equiv="refresh" content="0;URL=purchase.php">';
				die();
			}
			
			// Функция формирует форму для редактирования записи в таблице БД
			function get_edit_item_form()
			{
				global $link;
				echo '<div class="d_cont">';
				echo '<h2>Редактировать</h2>';
				$query = 'SELECT * FROM v_purchase WHERE id_purchase='.$_GET['id_purchase'];
				$res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link));
				$item = mysqli_fetch_array( $res );
				echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_purchase='.$_GET['id_purchase'].'" method="POST">';
				echo '<button type="button" onClick="history.back();">Отменить</button><br />';
				echo '<br><table border="1">';
				echo '<tr>';
				echo '<td>ФИО</td>';
				echo '<td>';
				$sql3 = 'SELECT * FROM buyer';
				
				$res3 = mysqli_query($link,$sql3) or die( "Error in $sql3 : " . mysql_error());
				
				echo '<select name="id_buyer">\r\n';
				echo '<option selected value="'.(int)$item['id_buyer'].'">'.$item['name_buyer'].'</option>';
				echo '<option disabled>------------------</option>';
				while($row = mysqli_fetch_array($res3))
				{
					$id_buyer = intval($row['id_buyer']);
					$name_buyer = htmlspecialchars($row['name_buyer']);
					echo "<option value=$id_buyer>$name_buyer</option>\r\n";
				}
				echo "</select>\r\n";
				echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
				echo '<td>Название</td>';
				echo '<td>';
				$sql4 = 'SELECT * FROM book';
				
				$res4 = mysqli_query($link,$sql4) or die( "Error in $sql4 : " . mysql_error());
				
				echo '<select name="id_book">\r\n';
				echo '<option selected value="'.(int)$item['id_book'].'">'.$item['name_book'].'</option>';
				echo '<option disabled>------------------</option>';
				while($row = mysqli_fetch_array($res4))
				{
					$id_book = intval($row['id_book']);
					$name_book = htmlspecialchars($row['name_book']);
					echo "<option value=$id_book>$name_book</option>\r\n";
				}
				echo "</select>\r\n";
				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Дата</td>';
				echo '<td><input type="text" name="date" value="'.$item['date'].'"></td>';
				echo '</tr>';
				echo '<tr align="center">';
				echo '<td colspan=2><input type="submit" value="Сохранить"></td>';
				echo '</tr>';
				echo '</table>';
				echo '</form>';
				echo '</div>';
				echo '<br>';
			}
			
			// Функция обновляет запись в таблице БД
			function update_item()
			{
				global $link;
				$id_buyer = mysqli_escape_string( $link, $_POST['id_buyer'] );
				$id_book = mysqli_escape_string( $link, $_POST['id_book'] );
				$date = mysqli_escape_string( $link, $_POST['date'] );
				$query = "UPDATE purchase SET id_buyer='".$id_buyer."',id_book='".$id_book."',date='".$date."' WHERE id_purchase=".$_GET['id_purchase'];
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу purchase.php
				echo '<meta http-equiv="refresh" content="0;URL=purchase.php">';
				die();
			}
			
			// Функция удаляет запись в таблице БД
			function delete_item()
			{
				global $link;
				$query = "DELETE FROM purchase WHERE id_purchase=".$_GET['id_purchase'];
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу purchase.php
				echo '<meta http-equiv="refresh" content="0;URL=purchase.php">';
				die();
			}
		?>
	</body>
</html>