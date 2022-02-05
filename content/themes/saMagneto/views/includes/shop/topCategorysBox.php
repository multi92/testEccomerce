<div class="row _unmargin">
    <div class="col-md-12 col-seter">
    	<div class="">
             <h4 class="after head-name"><?php echo $current_cat_data->name;?></h4>
        </div>
        
    </div>
</div>
<?php  if(isset($catsliderdata) && count($catsliderdata)>0) { ?>
<div class="row _unmargin">
	<div class="col-md-12 col-seter">
		<?php include($system_conf["theme_path"][1]."views/includes/slider/categorySlider.php");?>
    </div>
</div>
<?php } ?>
<hr>
<div class="row _unmargin">
<?php foreach($subcatsdata as $sval){ ?>
	<div class="col-sm-3 col-xs-6 col-seter">
        <?php include($system_conf["theme_path"][1]."views/includes/categorybox/categoryBox.php");?>
	</div>
<?php } ?>                    
</div>