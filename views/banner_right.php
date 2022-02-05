<?php if ($bannersright != -1) {?>
<div class="row">
    <div class="col-md-12">
        <div class="section-title">
            <h2 class="title"><?php echo $language["banner"][1];?></h2>
        </div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
    <?php foreach ($bannersright as $banner){ ?>
		<div class="baner-holder">
            <?php echo $banner['value']; ?>
        </div>
	<?php } ?>
    </div>
</div>
 <?php
            }
 ?>