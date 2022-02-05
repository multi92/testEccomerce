<div class="col-md-2 col-sm-3 col-xs-4 doc-holder">
    <a href="<?php echo $v[0]->relativepath; ?>" target="_self">
		<img src="<?php echo GlobalHelper::getImage($system_conf["theme_path"][1].$theme_conf["folder"][1], 'small'); ?>" alt="<?php echo ucfirst($v[0]->name); ?>" class="img-responsive">
	</a>
    <a href="<?php echo $v[0]->relativepath; ?>"><?php echo ucfirst($v[0]->name); ?></a>
</div>