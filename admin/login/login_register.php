	
	<div class="login_holder" >
        <div class="top_page_text1"><p>Prijavi se</p></div>
        <div class="loreg_left">
                <p class="text_form">E-Mail:</p>
                <p class="text_form">Lozinka:</p>      	
        </div>
        <div class="loreg_right">
            <form action="login/check.php" method="post" style="text-algin:left;" id="login_form">
            <div class="field-holder"><input type="text" id="username" name="username" class="field" /></div>
            <div class="field-holder"><input type="password" id="password" name="password" class="field" /></div>
            <div class="submit-button"><input type="button" name="submit_login_form_shop" value="Loguj se" class="submit" onclick="log_in()" /></div>
            </form>
            <div class="cl"></div>
            <a href="?go_to=password_retrival">Zaboravili ste lozinku?</a><br />
        </div>
    </div>
    
    <div class="register_holder">
    	<div class="top_page_text1"><p>Registruj nalog</p></div>

        <div class="loreg_left">
        	<p class="text_form">Ime:</p>
        	<p class="text_form">Prezime:</p>
        	<p class="text_form">E-Mail:</p>
        	<p class="text_form">Telefon:</p>
        	<p class="text_form">Lozinka:</p>
        	<p class="text_form">Potvrda lozinke:</p>
        	<p class="text_form">Adresa:</p>
        	<p class="text_form">Mesto:</p>
        	<p class="text_form">Postanski broj:</p>
        	
        </div>
        <div class="loreg_right">
            <form action="" method="post" style="text-algin:left;" id="register_form">
            <div class="field-holder"><input type="text" id="ime" name="ime" class="field" /></div>
            <div class="field-holder"><input type="text" id="prezime" name="prezime" class="field" /></div>
            <div class="field-holder"><input type="text" id="email" name="email" class="field" /></div>
            <div class="field-holder"><input type="text" id="telefon" name="telefon" class="field" /></div>
            <div class="field-holder"><input type="password" id="password" name="password" class="field" /></div>
            <div class="field-holder"><input type="password" id="again_password" name="again_password" class="field" /></div>
            <div class="field-holder"><input type="text" id="adresa" name="adresa" class="field" /></div>
            <div class="field-holder"><input type="text" id="mesto" name="mesto" class="field" /></div>
            <div class="field-holder"><input type="text" id="post_broj" name="post_broj" class="field" /></div>
            <div class="submit-button"><input type="button" name="submit_register_form" value="Registruj" class="submit" onclick="register_user()"  /></div>
            </form>
        </div>

    </div> 




