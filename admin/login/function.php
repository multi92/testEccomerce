<?php
include("../includes/config.php");
ini_set('display_errors', 0);
if(isset($_POST['query']))
{
	$q = $_POST['query'];
	switch($q)
	{
		case "check_name" :
		{
			$chname = str_replace(" ","<>",$_POST['name']);

			if(strlen($chname) > 0)
			{
				$query = "SELECT USERNAME FROM USER";
				$result = mysql_query($query);
				$a = "0";
				while($row = mysql_fetch_assoc($result))
				{

					if($row["USERNAME"] == $chname)
					{
						echo "<a style='color:red;'>Zauzeto</a><img src='../images/no.jpg' width='15' height='15' />";
						$a = "1";
						break;
					}
				}
				if($a == "0")
				{
					echo "<a style='color:green;'>Slobodno</a> <img src='../images/ok.jpg' width='15' height='15' />";
				}

			}
			else
				{
					echo "<a style='color:red;'>Molimo unesite Vase korisnicko ime</a>";
				}

		}		
		break;
	}
}
?>