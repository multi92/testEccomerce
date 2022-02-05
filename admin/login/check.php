<?php 
	if($_POST["username"] != NULL && $_POST["password"] != NULL)
	{
		//echo var_dump($_POST);
		$un = stripcslashes($_POST["username"]);
		$pw = stripcslashes($_POST["password"]);	
		//echo "email -> ".$un."password -> ".$pw;

		$query = "SELECT * FROM user WHERE email = '".$_POST["username"]."' AND password = '".md5($_POST["password"])."'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0){
			
			$row = mysqli_fetch_assoc($result);
			$_SESSION["status"] = "logged";
			$_SESSION["user_type"] = $row['type'];
			//$_SESSION["username"] = $row['USERNAME'];
			//$_SESSION["last_logged"] = $row['LAST_LOGGED'];
			$_SESSION["adresa"] = $row["address"];
			$_SESSION["mesto"] = $row["city"];
			$_SESSION["postbr"] = $row["zip"];
			$_SESSION["telefon"] = $row["phone"];
			$_SESSION["ime"] = $row["name"];
			$_SESSION["prezime"] = $row["surname"];
			$_SESSION["email"] = $row["email"];
			$_SESSION["picture"] = $row["picture"];
			$_SESSION["id"] = $row["id"];
			$year = date('Y');
			$month = date('M');
			$day = date('j');
			$hour = date('g') + 1;
			$min = date('i');
			$ap = date('A');
			$query = "UPDATE user SET LAST_LOGGED = NOW() WHERE id = ".$row['id'];
			mysqli_query($conn, $query);
			//header( "Location: http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI'] ); 
			//echo "<script>window.location.href = 'pantalej/admin/';< /script>"; 
			//break;
		}
		else{
			echo "Greska prilikom logovanja!";
		}

	}
	else
	{
	echo "poriuka 3";
	//header("Location: ../index.php");
	}

?>