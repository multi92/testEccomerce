<?php
echo "<a>Dobrodosli ".$_SESSION["username"]."</a><br />";
echo "<a>zadnje logovanje: ".$_SESSION["last_logged"]."</a><br /><br />";
echo '<a class="mouse_over" href="index.php?go_to=change_pass">Promeni lozinku</a><br /><br />';
echo '<a class="mouse_over" href="../includes/login/logout.php">Odjavi se</a><br />';

?>
