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
				$query = 'SELECT * FROM book INNER JOIN genre ON book.id_genre = genre.id_genre';
				$res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link));
				echo '<div class="d_cont">';
				echo '<h2>Книги в наличии</h2>';
				echo '<button type="button" onClick="history.back();">Назад</button><br>';
				echo '<br><table border="1">';
				echo '<tr align="center"><th>Название</th><th>Автор</th><th>Количество страниц</th>
					<th>Год</th><th>Издательство</th><th>Стоимость</th><th>Жанр</th><th></th><th></th></tr>';
				while ( $item = mysqli_fetch_array( $res ) )
				{
					echo '<tr align="center" class="tb1">';
					echo '<td>'.$item['name_book'].'</td>';
					echo '<td>'.$item['author'].'</td>';
					echo '<td>'.$item['pages'].'</td>';
					echo '<td>'.$item['year'].'</td>';
					echo '<td>'.$item['publisher'].'</td>';
					echo '<td>'.$item['price'].'</td>';
					echo '<td>'.$item['name_genre'].'</td>';
					echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_book='.$item['id_book'].'"><img src="img/edit.png" title="Редактировать"></a</td>';
					echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_book='.$item['id_book'].'"><img src="img/drop.png" title="Удалить"></a></td>';
					echo '</tr>';
				}
				echo '<tr align="center">
					  <td colspan=9>
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
				echo '<td>Название</td>';
				echo '<td><input type="text" name="name_book" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Автор</td>';
				echo '<td><input type="text" name="author" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Количество страниц</td>';
				echo '<td><input type="text" name="pages" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Год</td>';
				echo '<td><input type="text" name="year" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Издательство</td>';
				echo '<td><input type="text" name="publisher" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Стоимость</td>';
				echo '<td><input type="text" name="price" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Жанр</td>';
				echo '<td>';
				$sql1 = "Select * FROM genre";
				
				$res1 = mysqli_query($link, $sql1) or die( "Error in $sql1 : " . mysql_error());
				
				echo '<select name="id_genre">\r\n';
				echo "<option selected disabled>Выберите жанр</option>";
				while($row = mysqli_fetch_array($res1))
				{
					$id_genre = intval($row['id_genre']);
					$name_genre = htmlspecialchars($row['name_genre']);
					echo "<option value='$id_genre'>$name_genre</option>\r\n";
				}
				echo "</select>\r\n";
				echo '</td>';
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
				$name_book = mysqli_escape_string( $link, $_POST['name_book'] );
				$author = mysqli_escape_string( $link, $_POST['author'] );
				$pages = mysqli_escape_string( $link, $_POST['pages'] );
				$year = mysqli_escape_string( $link, $_POST['year'] );
				$publisher = mysqli_escape_string( $link, $_POST['publisher'] );
				$price = mysqli_escape_string( $link, $_POST['price'] );
				$id_genre = mysqli_escape_string( $link, $_POST['id_genre'] );
				$query = "INSERT INTO book (name_book, author, pages, year, publisher, price, id_genre)
				VALUES ('".$name_book."','".$author."','".$pages."','".$year."','".$publisher."','".$price."','".$id_genre."');";
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу book.php
				echo '<meta http-equiv="refresh" content="0;URL=book.php">';
				die();
			}
			
			// Функция формирует форму для редактирования записи в таблице БД
			function get_edit_item_form()
			{
				global $link;
				echo '<div class="d_cont">';
				echo '<h2>Редактировать</h2>';
				$query = 'SELECT * FROM book INNER JOIN genre ON book.id_genre = genre.id_genre WHERE book.id_book='.$_GET['id_book'];
				$res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link));
				$item = mysqli_fetch_array( $res );
				echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_book='.$_GET['id_book'].'" method="POST">';
				echo '<button type="button" onClick="history.back();">Отменить</button><br />';
				echo '<br><table border="1">';
				echo '<tr>';
				echo '<td>Название</td>';
				echo '<td><input type="text" name="name_book" value="'.$item['name_book'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Автор</td>';
				echo '<td><input type="text" name="author" value="'.$item['author'].'" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Количество страниц</td>';
				echo '<td><input type="text" name="pages" value="'.$item['pages'].'" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Год</td>';
				echo '<td><input type="text" name="year" value="'.$item['year'].'" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Издательство</td>';
				echo '<td><input type="text" name="publisher" value="'.$item['publisher'].'" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Стоимость</td>';
				echo '<td><input type="text" name="price" value="'.$item['price'].'" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Жанр</td>';
				echo '<td>';
				$sql2 = "Select * FROM genre";
				
				$res2 = mysqli_query($link, $sql2) or die( "Error in $sql2 : " . mysql_error());
				
				echo '<select name="id_genre">\r\n';
				echo '<option selected value="'.(int)$item['id_genre'].'">'.$item['name_genre'].'</option>';
				echo '<option disabled>------------------</option>';
				while($row = mysqli_fetch_array($res2))
				{
					$id_genre = intval($row['id_genre']);
					$name_genre = htmlspecialchars($row['name_genre']);
					echo "<option value='$id_genre'>$name_genre</option>\r\n";
				}
				echo "</select>\r\n";
				echo '</td>';
				echo '</tr>';
				echo '<tr align="center">';
				echo '<td colspan=2><input type="submit" value="Сохранить"></td>';
				echo '</tr>';
				echo '</table>';
				echo '</form>';
				echo '</div>';
			}
			
			// Функция обновляет запись в таблице БД
			function update_item()
			{
				global $link;
				$name_book = mysqli_escape_string( $link, $_POST['name_book'] );
				$author = mysqli_escape_string( $link, $_POST['author'] );
				$pages = mysqli_escape_string( $link, $_POST['pages'] );
				$year = mysqli_escape_string( $link, $_POST['year'] );
				$publisher = mysqli_escape_string( $link, $_POST['publisher'] );
				$price = mysqli_escape_string( $link, $_POST['price'] );
				$id_genre = mysqli_escape_string( $link, $_POST['id_genre'] );
				$query = "UPDATE book SET name_book='".$name_book."', author='".$author."', pages='".$pages."',
					year='".$year."', publisher='".$publisher."', price='".$price."', id_genre='".$id_genre."' WHERE id_book=".$_GET['id_book'];
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу book.php
				echo '<meta http-equiv="refresh" content="0;URL=book.php">';
				die();
			}
			
			// Функция удаляет запись в таблице БД
			function delete_item()
			{
				global $link;
				$query = "DELETE FROM book WHERE id_book=".$_GET['id_book'];
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу book.php
				echo '<meta http-equiv="refresh" content="0;URL=book.php">';
				die();
			}
		?>
	</body>
</html>