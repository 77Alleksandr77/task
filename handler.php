<?php
	$error = false;
	/* если авторизация прошла успешно*/
	if($_SESSION['user_name'])
	{
		header("Location:index.php");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ( $_POST['check'] )
	{
		header("Location:for_check.php");
	}
	else
	{
		$flag = false ;
		if ( !$_POST['user_name'] )
		{
			$flag = "Имя не введено";
			
		}
		else
		{
			$user_name = $_POST['user_name'];
		}
		if ( !$_POST['password'] )
		{
			$flag = "Пароль не введён";
		}
		else
		{
			$password = $_POST['password'];
		}
		if ( $flag )
		{
			$error[] = "Все поля обязательны к заполнению";
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		/*в форму регистрации ввели данные*//////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		if ( $_POST ['check_enter'] )
		{
			$day = $_POST['day'];
			$month = $_POST['month'];	
			$year = $_POST['year'];	
			
			$age = calculate_age ($day, $month, $year);
			if ($age < 5)
			{
				$error[] = "Too young!";
			}
			if ($age > 150)
			{
				$error[] = "Too old!";
			}
			if ($age < 0)
			{
				$error[] = "Вы ещё даже не родились!";
			}
			if ( $age === false )
			{
				$error[] =  "Некоректно введена дата рождения!";
			}		
			if ( !$error && !$flag )
			{
				$_SESSION['user_name'] = check_user( $user_name, $password, $connect );		
				/* добавляем Нового пользователя, со щетчиком равным 0 */
				if ( !$_SESSION['user_name'] )
				{	
					$error[] = "Такой ник есть!";	
				}
				else
				{
					include "inquiry.php";
					$_SESSION['counter'] = $counter;
				}
			}		
		}
		if( $_POST ['entrance']  ) /* нажат ВХОД */
		{
			if( !$error )
			{
				$_SESSION['user_name'] = enterance( $user_name, $password, $connect);
			}
			if ( !$_SESSION['user_name'] && !$flag )
			{	
				$error[] = "Не верный логин или пароль!";	
			}
		}
		$_SESSION ['my_error'] = $error;
		header("Location:index.php");
	}
?>
