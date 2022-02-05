<?php if ($bannerscenter != -1) {?>
<section class="horizontal-banners">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banners">
                <ul class="list">
                    <?php foreach ($bannerscenter as $banner){ ?>
                    <li class="items">

                             <?php echo $banner['value']; ?>

                    </li>
                    <?php } ?>
                </ul>
            </div>
            </div>
        </div>
    </div>
</section>    
<!-- <div class="row">
    <div class="col-md-12">
        <div class="section-title">
            <h2 class="title"><?php //echo $language["banner"][1];?></h2>
        </div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
    <?php //foreach ($bannerscenter as $banner){ ?>
		<div class="baner-holder">
            <?php //echo $banner['value']; ?>
        </div>
	<?php //} ?>
    </div>
</div> -->
 <?php } ?>