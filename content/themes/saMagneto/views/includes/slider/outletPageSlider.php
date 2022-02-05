<?php if(isset($outletpageslider) && count($outletpageslider)>0) { ?>
<section style="padding-top: 0!important;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <div class="myslider">
                    <div class="owl-carousel owl1">
                        <!-- ODNOS SLIKA U SLAJDERU 4:1 -->
						<?php foreach($outletpageslider as $val){ ?>
                        <div><img src="<?php echo GlobalHelper::getImage($val['item'], 'big'); ?>" alt="<?php echo $user_conf["sitetitle"];?>" class="img-responsive"></div>
						<?php } ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
<?php } ?>