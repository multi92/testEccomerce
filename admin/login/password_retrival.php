<div class="contact_form_holder">

	
    <div class="menu_top"></div>
    <div class="middle">
    														
            <div class="shopcart_holder" id="shopcart_holder">	
<?php
if(isset($_POST['pass_submit']))
{
	$email=stripslashes($_POST['email']);
	$query = "SELECT email FROM user ";
	$result = mysql_query($query);
	$i = 1;
	while($email_row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		if($email_row['email'] == $email)
		{
			$pass = random_pass();
						
			$to = $email;
			
			$from="noreplay@milkhouse.co.rs ";
			
			$msg="Password:$pass\r\n";
			$msg .="Please change your password as soon as you logon\r\n\n";
			
			$msg .= "---User information--- \r\n"; //Title
			$msg .= "IP adresa : ".$_SERVER["REMOTE_ADDR"]."\r\n"; //Sender's IP
			$msg .= "Preglednik : ".$_SERVER["HTTP_USER_AGENT"]."\r\n"; //User agent

			$subject="Your Login Password\r\n";
			
			$passenc = pass_enc($pass);
			
			$query = "UPDATE user SET password = '".$passenc."' WHERE email = '".$email."'  LIMIT 1";
			if(mysql_query($query))
			{
				if  (mail($to, $subject, $msg, "From: $from\r\nReply-To: $from\r\nReturn-Path: $from\r\n"))
				{
					echo '<h2>Vasa lozinka je poslata na '.$email.'<br />Molimo proverite Vasu email adresu</h2><br /><a href="?">pocetna</a>';
					$i = "err";

				}
				else
				{
					echo "<script>show_message('Greska prilikom slanja','fail')</script>";
				}
			}
			$i = "err";
			break;
		}
	}
	if($i != "err")
	{
		echo "<script>show_message('Email adresa ne postoji u bazi','fail')</script>";
	}

}

if(!isset($i) || $i != "err")
	{
?>
                <div class="login_register_holder">
                	<div class="top_page_text1"><p>Unesite Vasu E-mail adresu:</p></div>
                    <div class="loreg_left">
                            <p class="text_form">E-Mail:</p>      	
                    </div>
                    <div class="loreg_right">
                    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="field-holder"><input type="text" class="field" name="email" /></div>
                    <div class="submit-button"><input type="submit" name="pass_submit" value="posalji" /></div>
                    </form>
                    <div class="cl"></div>
                        
                    </div>
                </div>
<?php 
	}
?>
</div>								
		<div class="cl"></div>														
		</div>
        
    <div class="menu_bottom"></div>
</div>
<div class="cl"></div>