<html>
<head></head>
<body>
<div id="center" align="center">
<img src="../images/header/SCF98_1.png" width="700" height="85" />
<br />
<?php
ini_set('display_errors', 1);
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
function check_name()
{
	var test = $('input[name="new_username"]').val();

	$.ajax({
			type : 'POST',
			url : 'function.php',
			data : "query=check_name&name=" + test,
			
			success : function(data){
				alert(data);
				//$("input[name='new_username']").next().html(data);
				},
			});
}
function check_empty(as)
{
	if(as == "name")
	{
		var v = $("input[name='name']").val(); 
		if(v == "")
		{
			$("input[name='name']").next().html("<a style='color:red;'>Molimo unesite vase ime</a>");
		}
		else
		{
			$("input[name='name']").next().html(" &#8201;");
		}
		
	}
	
	if(as == "lastname")
	{
		var v = $("input[name='lastname']").val(); 
		if(v == "")
		{
			$("input[name='lastname']").next().html("<a style='color:red;'>Molimo unesite vase prezimee</a>");
		}
		else
		{
			$("input[name='lastname']").next().html(" &#8201;");
		}
	}
}
function check_all()
{
	var a = $('input[name="new_username"]').val();
	var b = $("input[name='name']").val();
	var c = $("input[name='lastname']").val(); 
	if(a == "" || b == "" || c == "")
	{
		$("input[type=submit]").attr('disabled', 'disabled');
	}
	else
	{
		$("input[type=submit]").attr('disabled', '');
	}
		
}
</script>
<?php

if(isset($_POST['new_user']))
{
	$username = stripcslashes($_POST['new_username']);
	$name = stripcslashes($_POST['name']);
	$lastname = stripcslashes($_POST['lastname']);
	$mail = $_POST['email'];
	include("../includes/config.php");
	$query = "UPDATE USER SET CONFIRM = 'activated', NAME = '".$name."', LASTNAME = '".$lastname."', USERNAME='".$username."'  WHERE USER_EMAIL = '".$mail."' LIMIT 1";
	if(mysql_query($query))
	{
		echo "Aktivacija naloga je uspesna!!! redirecting...";
		echo "<script> $(document).ready(function(){	setTimeout(function() { window.location.href = \"http://www.google.com\";}, 8000);	});</script> ";
	}
	else echo mysql_error();
	
}

elseif(isset($_GET['link']))
{
	if(isset($_GET['mail']))
	{
		include("../includes/function.php");
		include("../includes/config.php");
		$query = "SELECT * FROM USER WHERE USER_EMAIL='".$_GET['mail']."' ";
		$result = mysql_query($query);
		$data = mysql_fetch_row($result);
		if($data[6] == $_GET['link'])
		{
			echo'<a>Molimo vas popunite formu ispod:</a><br />
			<form method="post" action="'.$_SERVER["PHP_SELF"].'">
			<br />
			<table width="300" cellspacing="5">
			<tr>
			<td width="100">Korisnicko ime: </td>
			<td><input size="30" type="text" name="new_username" onblur="check_name()" /><a class="msg" ></a></td>
			</tr>
			<tr>
			<td width="100">Ime: </td>
			<td><input size="30" type="text" name="name" onblur="check_empty(\'name\')" /><a class="msg" >&#8201;</a></td>
			</tr>
			<tr>
			<td width="100">Prezime: </td>
			<td><input size="30" type="text"  name="lastname" onblur="check_empty(\'lastname\')" /><a class="msg" >&#8201;</a></td>
			</tr>
			<tr>
			<td>
			<input type="hidden" name="email" value="'.$_GET['mail'].'" />
			<input type="submit" name="new_user" value="Snimi"  /></td>
			<td>Sva polja su obavezna!!! </td>
			</tr>
			</table>
			</form>
			</form>';
						
		}
		else
		{
			echo "redirecting...";
			echo "<script> $(document).ready(function(){	setTimeout(function() { window.location.href = \"http://www.google.com\";}, 1000);	});</script> ";
		}				
	}
	else
		{
			echo "redirecting...2";
			echo "<script> $(document).ready(function(){	setTimeout(function() { window.location.href = \"http://www.google.com\";}, 8000);	});</script> ";
		}
}
else
{
echo "redirecting...3";
		echo "<script> $(document).ready(function(){	setTimeout(function() { window.location.href = \"http://www.google.com\";}, 8000);	});</script> ";
}
?>
</div>
</body>
</html>

