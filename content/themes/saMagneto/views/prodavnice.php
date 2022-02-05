
<div class="page-head">

	<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope
					itemtype="http://schema.org/ListItem">
					<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
						<span itemprop="name"><?php echo $language["global"][3]; ?></span>
					</a>

				</li>

				<li class="active" itemprop="itemListElement" itemscope
				itemtype="http://schema.org/ListItem">
				<span itemprop="name"><?php echo $language["shops"][1]; ?></span>
			</li>
		</ol>

</div>
<section class="content">
	<!-- <div class="page-head">
		<div class="container">

			<div class="row noMargin">
			<div class="col-md-12">
				<h4 class="after marginBottom30"><?php// echo $language["shops"][1]; ?></h4>
			</div>
			</div>
		</div>
	</div> -->
	<div class="container">
		<div class="content-page">
			<div class="row noMargin">
			<div class="col-md-12">
				<h4 class="after marginBottom30"><?php echo $language["shops"][1]; ?></h4>
			</div>
			</div>
			<div class="row noMargin">
			<div class="col-md-12">
				<?php foreach($shops[1] as $val){ //var_dump($val);?>
				<div class="store">
					<div class="info">
						<h4 class="title"><b><?php echo $val->name;?></b></h4>
						<ul class="list">
							<li class="items">
								<i class="material-icons icons">location_on</i>
								<span class="dinamic"><?php echo $val->address.', '.$val->cityname;?></span>
							</li>
							<?php if(isset($val->phone) && strlen($val->phone)>0){?>
							<li class="items">
								<i class="material-icons icons">phone_android</i>
								<span class="dinamic">
									<a href="tel:<?php echo $val->phone;?>"><?php echo $val->phone;?></a>
								</span>
							</li>
							<?php }?>
							<?php if(isset($val->cellphone) && strlen($val->cellphone)>0){?>
							<li class="items">
								<i class="material-icons icons">phone_android</i>
								<span class="dinamic">
									<a href="tel:<?php echo $val->cellphone;?>"><?php echo $val->cellphone;?></a>
								</span>
							</li>
							<?php }?>
							<?php if(isset($val->email) && strlen($val->email)>0){?>
							<li class="items">
								<i class="material-icons icons">email</i>
								<span class="dinamic">
									<a href="mailto:<?php echo $val->email;?>"><?php echo $val->email;?></a>
								</span>
							</li>
							<?php }?>
							<?php $worktime = json_decode($val->worktime, true); ?>
								<li class="items"><i class="material-icons icons">access_time</i> 
									<span class="dinamic">
										<?php echo ($worktime['mf']['from'] == "")? "": "".$language["shops"][2].": <b>".$worktime['mf']['from']." - ".$worktime['mf']['to']."</b>;"; ?>
					 					<?php echo ($worktime['st']['from'] == "")? "": "".$language["shops"][3].": <b>".$worktime['st']['from']." - ".$worktime['st']['to']."</b>;"; ?>
					 					<?php echo ($worktime['su']['from'] == "")? "".$language["shops"][4].": <b>".$language["shops"][5]."</b>;": "nedelja: <b>".$worktime['su']['from']." - ".$worktime['su']['to']."</b>;"; ?> 
								</span>
								</li>
						</ul>
						
					</div>
					
					<div class="gallery-holder">
						<img src="<?php echo $val->thumb;?>" alt="" class="img-responsive image" />
					</div>
				</div>
				<?php }?>
			</div>
		</div>
		</div>
		
	</div>
</section>