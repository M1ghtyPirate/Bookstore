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
				$query = 'SELECT * FROM buyer';
				$res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link));
				echo '<div class="d_cont">';
				echo '<h2>Список покупателей</h2>';
				echo '<button type="button" onClick="history.back();">Назад</button><br>';
				echo '<br><table border="1">';
				echo '<tr align="center"><th>ФИО</th><th>Телефон</th><th></th><th></th></tr>';
				while ( $item = mysqli_fetch_array( $res ) )
				{
					echo '<tr align="center" class="tb1">';
					echo '<td>'.$item['name_buyer'].'</td>';
					echo '<td>'.$item['phone'].'</td>';
					echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_buyer='.$item['id_buyer'].'"><img src="img/edit.png" title="Редактировать"></a</td>';
					echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_buyer='.$item['id_buyer'].'"><img src="img/drop.png" title="Удалить"></a></td>';
					echo '</tr>';
				}
				echo '<tr align="center">
					  <td colspan=4>
						<a href="'.$_SERVER['PHP_SELF'].'?action=addform"><button type="button">Добавить</button></a>
					  </td>
					  </tr>';
				echo '</table>';
				echo '</div>';
			}
			
			// Функция формирует форму для добавления записи в таблице БД
			function get_add_item_form()
			{
				echo '<div class="d_cont">';
				echo '<h2>Добавить</h2>';
				echo '<form name="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
				echo '<button type="button" onClick="history.back();">Отменить</button><br />';
				echo '<br><table border="1">';
				echo '<tr>';
				echo '<td>ФИО</td>';
				echo '<td><input type="text" name="name_buyer" value="" /></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Телефон</td>';
				echo '<td><input type="text" name="phone" value="" /></td>';
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
				$name_buyer = mysqli_escape_string( $link, $_POST['name_buyer'] );
				$phone = mysqli_escape_string( $link, $_POST['phone'] );
				$query = "INSERT INTO buyer (name_buyer, phone) VALUES ('".$name_buyer."','".$phone."');";
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу buyer.php
				echo '<meta http-equiv="refresh" content="0;URL=buyer.php">';
				die();
			}
			
			// Функция формирует форму для редактирования записи в таблице БД
			function get_edit_item_form()
			{
				global $link;
				echo '<div class="d_cont">';
				echo '<h2>Редактировать</h2>';
				$query = 'SELECT * FROM buyer WHERE id_buyer='.$_GET['id_buyer'];
				$res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link));
				$item = mysqli_fetch_array( $res );
				echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_buyer='.$_GET['id_buyer'].'" method="POST">';
				echo '<button type="button" onClick="history.back();">Отменить</button><br />';
				echo '<br><table border="1">';
				echo '<tr>';
				echo '<td>ФИО</td>';
				echo '<td><input type="text" name="name_buyer" value="'.$item['name_buyer'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Телефон</td>';
				echo '<td><input type="text" name="phone" value="'.$item['phone'].'"></td>';
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
				$name_buyer = mysqli_escape_string( $link, $_POST['name_buyer'] );
				$phone = mysqli_escape_string( $link, $_POST['phone'] );
				$query = "UPDATE buyer SET name_buyer='".$name_buyer."',phone='".$phone."' WHERE id_buyer=".$_GET['id_buyer'];
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу buyer.php
				echo '<meta http-equiv="refresh" content="0;URL=buyer.php">';
				die();
			}
			
			// Функция удаляет запись в таблице БД
			function delete_item()
			{
				global $link;
				$query = "DELETE FROM buyer WHERE id_buyer=".$_GET['id_buyer'];
				mysqli_query ( $link, $query ) or die("Ошибка " . mysqli_error($link));
				// Осуществляем перенаправление (редирект) на страницу buyer.php
				echo '<meta http-equiv="refresh" content="0;URL=buyer.php">';
				die();
			}
		?>
	</body>
</html>