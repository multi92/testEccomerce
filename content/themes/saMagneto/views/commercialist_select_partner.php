<section class="commercialist-chose-page">	
	<div class="container container_commercilalist_partner" partnerid="<?php echo $_SESSION['partnerid'];?>" partneraddressid="<?php echo $_SESSION['partneraddressid'];?>" langid="<?php echo $_SESSION['langid'];?>" langcode="<?php echo $_SESSION['langcode'];?>">
		<div class="row">
			<div class="col-md-12">
				<h3><?php echo $language["commercialist_partner"][1];?></h3>
				<div class="row">
					<div class="col-md-12 table-responsive">
						<table id="commercilalist_partner" class="table table-striped table-bordered" style="width:100%">
        					<thead>
            					<tr>
            					    <th><?php echo $language["commercialist_partner_table"][1];//Partner?></th>
            					    <th><?php echo $language["commercialist_partner_table"][2];//PIB?></th>
           					     	<th><?php echo $language["commercialist_partner_table"][3];//Adresa partnera?></th>
            					    <th></th>
           					     
           					 	</tr>
        					</thead>
        					<tbody>
        					</tbody>
        				</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>