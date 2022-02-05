<h4 class="aditi title"><?php echo $language["orderhelpmenu"][1]; //Pomoć pri kupovini ?></h4>
<ul class="cart-help-ul">
<?php foreach($orderHelpMenuData as $ohmkey=>$ohmval){ ?>
	 <li class="cart-help-li"><a href="<?php echo $ohmval['link']; ?>" class="links">
	 	<i class="material-icons icons">error_outline</i> 
	 	<?php echo $ohmval['value']; ?></a></li>
<?php } ?>                    
</ul>