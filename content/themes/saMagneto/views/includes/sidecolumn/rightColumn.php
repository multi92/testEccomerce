<?php if($command[0]=='news') { ?>
<div class="news-help-holder">
	<div class="news-search-holder">
		<form class="mySearch-form" action="pretraga" role="search1" autocomplete="off" method="get" name="Pretraži">
			<input type="text" name="q" placeholder="<?php  echo $language["global"][2]; //Pretrazi ?>...">
			<input type="text" name="t" value="news" hidden>
			<button class="btn myBtn"><i class="material-icons">search</i></button>
		</form>
		<div class="news-help-head hide">
			<p><?php echo $language["right_col"][1]; //Ukucajte kljucnu rec i pretrazite vesti ?></p>
		</div>
	</div>
</div>
<?php } ?>
<?php foreach($bannersright as $bsval){?>
<div class="news-baner">
	<?php echo $bsval["value"]; ?>
</div>
<?php } ?>

