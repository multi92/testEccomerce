<div class="row noMargin">
    <div class="section-title">
        <h4 class="title"><?php echo $language["shop"][1]; ?></h4>
    </div>
</div>
<?php  if(isset($catsliderdata) && count($catsliderdata)>0) { ?>
<div class="row noMargin">
	<div class="col-md-12 col-seter">
		<?php include($system_conf["theme_path"][1]."views/includes/slider/categorySlider.php");?>
    </div>
</div>
<?php } ?>
<hr>
<div class="row noMargin">
	
<?php  foreach($catdata as $sval){ ?>

	<div class="col-sm-3 col-xs-6 col-seter ">
        <?php include($system_conf["theme_path"][1]."views/includes/categorybox/shopBrendsCategoryBox.php");?>
	</div>
<?php } ?>                    
</div>