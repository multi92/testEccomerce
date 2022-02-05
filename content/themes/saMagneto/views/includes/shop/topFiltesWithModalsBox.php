
<?php 
	$show_filters='visible-sm visible-xs';
	if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged" && isset($_SESSION["shoptype"]) && $_SESSION["shoptype"]=="b2b"){
		$show_filters='';
 }?>
<!-- new element -->
<div class="row _unmargin <?php echo $show_filters; ?>">
	<div class="col-xs-6 col-seter">
		<button class="sa-button -filter " id="jq_categoryMobileMenuTrigger">Proizvodi <i class="material-icons icons">sort</i></button>
	</div>
	<div class="col-xs-6 col-seter">
		<button class="sa-button -filter " id="filterModalTrigger">Filteri <i class="material-icons icons">tune</i></button>
	</div>	
	<hr>
</div>
<!-- new element end -->


