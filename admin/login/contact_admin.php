<div id="center">
<?php
if(isset($_POST['contact_admin_subbmit']))
{
	if($_POST['ime'] == NULL || $_POST['mail'] == NULL || $_POST['poruka'] == NULL)
	{
		$err = "4";
	}
	else
	{
		if($_POST['naslov'] == NULL)
		{
			$subject = '<No Subject>';
		}
		else
		{
			$subject = $_POST['naslov'];
		}
		$to      = 'mimiklonet@hotmail.com';
		$message = $_POST['poruka'];
		$headers = 'From: '.$_POST['mail']. "\r\n";
		
		if(mail($to, $subject, $message, $headers))
		{
			echo "uspesno poslato";
		}
		else
		{
			echo "error mail";
		}

	}
}
if(isset($err))
{
	error($err);
}
else
{
echo "<a>Samostalna registracija trenutno nije dostupna!!!</a><br />";
echo "<a>Kontaktirajte administratora pomocu forme ispod</a>";
}
 include("includes/contact_form_admin.php");?>

</div>