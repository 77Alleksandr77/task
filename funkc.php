<?php	
	function calculate_age($day, $month, $year) /* получить возраст */
	{
		$age = checkdate ( $month, $day, $year );
		if( !$age )
		{
			return false;
		}
		else
		{		
			$age = date('Y') - $year;
			if ( date('m') < $month ) 
			{
				$age--;
			}
			if ( date('m') == $month ) 
			{
				if ( date('d') < $day )
				{
					$age--;
				}
			}
		}
		return $age;
	}
	$mysqli = false;
	function connectDB() /* подключиться к БД */
	{
		global $mysqli;
		$mysqli=new mysqli("","","","");
		$mysqli->set_charset('UTF8');
		if (!$mysqli)
		{
			echo "соединение с БД не удалось<br>";
			return false;
		}
		else return $mysqli;
	}
	function check_user( $user_name, $password, $connect ) /* добавить пользователя и счетчек = 0 */
	{
		$table = 'counter';
		$count = 0;
		$user_name_escape = mysqli_real_escape_string($connect, $user_name);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$success = mysqli_query( $connect, "INSERT INTO  `$table`(`name` ,`pass` ,`count`)
		VALUES ('$user_name_escape','$password','$count')");
		if ( $success )
		{ 
			return $user_name;
		}
		else 
		{
			return false;
		}
	}
	function get_counter ( $user_name, $connect ) /* получить счетчек */
	{
		$table = 'counter';
		$user_name = mysqli_real_escape_string($connect, $user_name);
		$result_set =  mysqli_query( $connect, " SELECT `count` FROM `$table` WHERE `name` = '$user_name' ");
		$count = $result_set->fetch_assoc();
		
		if($count)
		{
			return $count["count"];
		}
		else
		{
			return false;
		}		
	}
	function eneter_counter($user_name, $counter, $connect) /* изменить значение счетчика */
	{
		$table = 'counter';
		$user_name = mysqli_real_escape_string($connect, $user_name);
		$success = mysqli_query ( $connect, " UPDATE `$table` SET `count` = '$counter' 
		WHERE `name` = '$user_name' " );
	}
	function enterance( $user_name, $user_password, $connect) /* вход в аккаунт */
	{
		$table = 'counter';
		$user_name_escape = mysqli_real_escape_string($connect, $user_name);
		$result_set = mysqli_query ($connect, " SELECT  `pass` FROM `$table` WHERE `name`='$user_name_escape' "); 
		$received_pass = $result_set->fetch_assoc();
		if($received_pass) 
		{
			foreach($received_pass as $val);			
			if (password_verify($user_password, $val))
			{
				return $user_name;
			}
			else return false;			
		}
		else
		{
			return false;
		}
	}
	function closeDB($mysqli)	
	{
		$mysqli->close();
	}
?>
