
<div class="content-wrapper">

	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-home"></i> Početna
		</h1>
		
	</section>
    <!-- Main content -->
    <section class="content-header" style="min-height:auto;">
    	<div class="alert alert-success alert-dismissible">
                <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                <h4><i class="icon fa fa-check"></i> Dobrodošli</h4>
                Za početak odaberite opciju iz menija sa leve strane.
        </div>
            	<!-- CHECK CURRENCY -->
    	<?php 
    		$currencyCheck='';
    		$q="SELECT c.* FROM currency AS c WHERE c.CODE != 'RSD' AND LEFT(c.mainvaluets,10) != LEFT(NOW(),10)  ";
    		$re = mysqli_query($conn, $q);
			
			if(mysqli_num_rows($re) == 1){
				$row = mysqli_fetch_assoc($re);
				$currencyCheck.='<div class="alert alert-danger alert-dismissible">';
				$currencyCheck.='<h4><i class="icon fa fa-exclamation-circle"></i> Vrednost valute <b>'.$row['code'].'</b> nije ažurna. Poslednji put je ažurirana '.date("d.m.Y",strtotime($row['mainvaluets'])).' u '.date("h:i:s",strtotime($row['mainvaluets'])).'. Trenutna vrednost valute je '.$row['mainvalue'].' RSD</h4>';
				$currencyCheck.='<a href="globalconfig/#globalconfigCurrency" >Izmenite vrednosti valuta</a>';
				$currencyCheck.='</div>';
			} else if(mysqli_num_rows($re) > 1){
				$currencyCheck.='<div class="alert alert-danger alert-dismissible">';
				while($row = mysqli_fetch_assoc($re))
				{
					$currencyCheck.='<h4><i class="icon fa fa-exclamation-circle"></i> Vrednost valute <b>'.$row['code'].'</b> nije ažurna. Poslednji put je ažurirana '.date("d.m.Y",strtotime($row['mainvaluets'])).' u '.date("h:i:s",strtotime($row['mainvaluets'])).'. Trenutna vrednost valute je '.$row['mainvalue'].' RSD</h4>';
				}
				$currencyCheck.='<a href="globalconfig/#globalconfigCurrency" >Izmenite vrednosti valuta</a>';
				$currencyCheck.='</div>';

			} else {
				$currencyCheck='';
			}
			echo $currencyCheck;
    	?>


    	<!-- CHECK CURRENCY END -->

        <!--<div class="row">
			<div class="col-xs-12">
				<h2 class="headline text-green"> Dobrodošli</h2>
			</div>
			<div class="col-xs-12">
				<h4 class=" "> Za početak odaberite opciju iz menija sa leve strane.</h4>
			</div>
		</div>-->
	</section><!-- /.content -->
	<section class="content">

 <!-- target="_blank" -->
<div class="row" style="height=400px; min-height:auto;">
	
	
	<div class="col-lg-3 col-xs-12">
          
          <div class="small-box bg-aqua">
            <div class="inner">
			<?php 
			$q = "SELECT count(u.id) AS `cnt` 
					FROM user AS u 
					WHERE  u.`type`!='admin'";
			$re = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($re);
			?>
			
              <h3><?php echo $row["cnt"]?></h3>

              <p>Ukupno klijenata</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="users" target="_blank" class="small-box-footer">
              Pogledaj korisnike <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
    </div>
	<div class="col-lg-3 col-xs-12">
          
          <div class="small-box bg-teal">
            <div class="inner">
			<?php 
			$q = "SELECT count(u.id) AS `cnt` 
					FROM partner AS u ";
			$re = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($re);
			?>
			
              <h3><?php echo $row["cnt"]?></h3>

              <p>Ukupno partnera</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="partner" target="_blank" class="small-box-footer">
              Pogledaj partnere <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
    </div>
	<div class="col-lg-3 col-xs-12 hide">
          
          <div class="small-box bg-aqua">
            <div class="inner">
			<?php 
			
			$q = "SELECT count(uld.userid) AS `cnt` 
					FROM userlogdata AS uld 
					LEFT JOIN user AS u ON uld.userid=u.id
					WHERE uld.ts> DATE_SUB( now(), INTERVAL 5 MINUTE)
					AND u.`type`!='admin'";
			$re = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($re);
			?>
              <h3><?php echo $row["cnt"]?></h3>

              <p>Klijenata na sajtu</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">
              Više informacija <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
    </div>
    <div class="col-lg-3 col-xs-12">
          
          <div class="small-box bg-yellow">
            <div class="inner">
			<?php 
			
			$q = "SELECT count(d.id) AS `cnt` 
					FROM b2c_document AS d 
					LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
					
					WHERE dd.customeremail != '' AND d.status='n' AND documenttype='E'";
			$re = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($re);
			?>
              <h3><?php echo $row["cnt"]?></h3>

              <p>Novih B2C porudžbina</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="order" target="_blank" class="small-box-footer">
              Pogledaj B2C porudžbine <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
    </div>
    <div class="col-lg-3 col-xs-12">
          
          <div class="small-box bg-orange hide">
            <div class="inner">
			<?php 
			
			$q = "SELECT count(d.id) AS `cnt` 
					FROM b2b_document AS d 
					LEFT JOIN b2b_documentdetail AS dd ON d.id=dd.b2b_documentid
					
					WHERE dd.customeremail != '' AND d.status='o' AND documenttype='E'";
			$re = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($re);
			?>
              <h3><?php echo $row["cnt"]?></h3>

              <p>Novih B2B porudžbina</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="invoice" target="_blank" class="small-box-footer">
              Pogledaj B2B porudžbine <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
    </div>
    
</div>
<div class="row">
    		<div class="col-lg-12 col-xs-12">
				<div class="box box-info" >
					<div class="box-header with-border">
              <h3 class="box-title">Moduli</h3>

              <div class="box-tools pull-right" >
                <button type="button" class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" ><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" >
            	
            	<?php
				if($_SESSION['user_type'] == "admin")
				{
					$query = "SELECT * FROM adminmoduls am WHERE am.menivisible = 1 AND sort>0 ORDER BY sort ASC";
				}
				else{
					$query = "SELECT am.*, ug.see, ug.change, ug.add, ug.delete, ug.activate, up.moduleid 
					FROM adminmoduls AS am 
					LEFT JOIN userprivilage up ON am.id = up.moduleid 
					LEFT JOIN usergroup ug ON up.groupid = ug.id
					WHERE am.menivisible = 1 AND am.sort>0 AND ug.see = 1 AND up.userid =".$_SESSION['id']." ORDER BY sort ASC";
				}
				$re = mysqli_query($conn, $query);
				
				
				if(mysqli_num_rows($re) > 0)
				{
					while($row = mysqli_fetch_assoc($re))
					{
						
						
						

						echo '<a href="'.ROOTPATHLINK.''.$row['name'].'" class="btn btn-app btn-modul " style="color:'.$row['color'].';background-color:'.$row['bgcolor'].';">
                				<i class="fa '.$row['icon'].'"></i> '.ucfirst($row['showname']).'
              				  </a>';
						
					}
				}
				
				?>



            	
              	






            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix hide" >
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>

				</div>
			</div>
		</div>    
<?php 

	$query="SELECT p.`id`,p.`code`, p.`name`, s.`count` FROM statistics AS s LEFT JOIN product AS p ON s.foreign_id=p.id AND s.foreign_table='product'  WHERE s.foreign_table='product' ORDER BY s.`count` DESC, p.ts DESC LIMIT 0,10  ";
	$re = mysqli_query($conn, $query);
	$i=0;
?>
<div class="row">
	<div class="col-lg-6 col-xs-12">
	<div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">Najpregledaniji proizvodi</h3>

              <div class="box-tools pull-right" >
                <button type="button" class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" ><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" >
              <div class="table-responsive" >
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Sifra</th>
                    <th>Naziv</th>
                    <th>Broj pregleda</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while($arow = mysqli_fetch_assoc($re)){
				  	$i++;
				  	$style='';
				  	if($i<2){$style='label-danger';} else if($i>=2 && $i<4){$style='label-warning';} else {$style='label-success';}
				  	echo '<tr>
				  			<td>'.$arow['code'].'</td>
				  			<td>'.$arow['name'].'</td>
				  			<td><span class="label '.$style.'">'.$arow['count'].'</span></td>
				  			<td>
				  				<a href="product/change/'.$arow['id'].'" class="btn btn-sm btn-info btn-flat pull-left">Pogledaj proizvod</a>
				  			</td>
				  		 </tr>';
				  }?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix hide" >
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
          </div>
	 </div>

<?php 
	$query='SELECT op.productid AS `id`, p.code, p.name, SUM(op.c) AS `count` 
				FROM (SELECT c.productid AS `productid` ,COUNT(c.productid)  AS  c FROM b2c_documentitem AS c GROUP BY c.productid
						UNION
					  SELECT b.productid AS `productid` ,COUNT(b.productid) AS  c FROM b2b_documentitem AS b GROUP BY b.productid
					  ) AS op 
				LEFT JOIN product AS p ON op.productid=p.id GROUP BY op.productid ORDER BY `count` DESC LIMIT 0,10';
	$re = mysqli_query($conn, $query);
	$i=0;


?>	

	<div class="col-lg-6 col-xs-12">
	<div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">Najviše poručivani proizvodi</h3>

              <div class="box-tools pull-right" >
                <button type="button" class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" ><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" >
              <div class="table-responsive" >
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Sifra</th>
                    <th>Naziv</th>
                    <th>Broj poručenih</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while($arow = mysqli_fetch_assoc($re)){
				  	$i++;
				  	$style='';
				  	if($i<2){$style='label-danger';} else if($i>=2 && $i<4){$style='label-warning';} else {$style='label-success';}
				  	echo '<tr>
				  			<td>'.$arow['code'].'</td>
				  			<td>'.$arow['name'].'</td>
				  			<td><span class="label '.$style.'">'.$arow['count'].'</span></td>
				  			<td>
				  				<a href="product/change/'.$arow['id'].'" class="btn btn-sm btn-info btn-flat pull-left">Pogledaj proizvod</a>
				  			</td>
				  		 </tr>';
				  }?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix hide" >
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
          </div>
	 </div>
</div>
	<div class="row" >
        <div class="col-sm-6 col-xs-12 hide" >
          <div class="box" >
            <div class="box-header">
              <h3 class="box-title">TOP 10 najposećenijih proizvoda</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body  table-responsive ">
				<table class="table table-hover">
					<tbody>
						<tr>
							<th>Šifra</th>
							<th>Proizvod</th>
							<th>Broj pregleda</th>
						</tr>
				<?php
							$query = "SELECT count(c.foreign_id) AS cnt, p.*
										FROM countdata as c 
										LEFT JOIN product AS p ON c.foreign_id=p.id
										WHERE c.foreign_table ='product'
										GROUP BY c.foreign_id
									ORDER BY cnt DESC
									LIMIT 0,10";
									
							$re = mysqli_query($conn, $query);
							$i=0;
							while($arow = mysqli_fetch_assoc($re))
							{
								$i++;
								$style='';
								if($i<2){$style='label-danger';} else if($i>=2 && $i<4){$style='label-warning';} else {$style='label-success';}
								echo '<tr>
										<td>'.$arow['code'].'</td>
										<td>'.$arow['name'].'</td>
										<td><span class="label '.$style.'">'.$arow['cnt'].'</span></td>
									 </tr>';
							}
				?>

					</tbody>
				</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		<!-- CHART -->
		<?php 	
				$show_daily_product_chart=false;
				$query = "SELECT COUNT(DATE_FORMAT(c.ts, '%H')) AS `cnt`,
							DATE_FORMAT(c.ts, '%Y-%m-%d') AS `date` ,
							DATE_FORMAT(c.ts, '%H') AS `hour`
						FROM countdata AS c 
						GROUP BY `date`, `hour`
						HAVING `date`=DATE(NOW() - INTERVAL 1 DAY)";
				$res = mysqli_query($conn, $query);	
				
				$row_cnt = mysqli_num_rows($res);
				
				//if(count($row_cnt)){
				//	$show_daily_product_chart=true;
				//}
		
		?>
		<?php if($show_daily_product_chart){ ?>
		<?php 	$daily_product_chart_data=array();
		
				for ($i = 0; $i<=23 ; $i++) {
					$hour_str='';
					if($i<10){ $hour_str='0'.strval($i); } else { $hour_str=strval($i); }
					
					$query = "SELECT COUNT(DATE_FORMAT(c.ts, '%H')) AS `cnt`,
							DATE_FORMAT(c.ts, '%Y-%m-%d') AS `date` ,
							DATE_FORMAT(c.ts, '%H') AS `hour`
						FROM countdata AS c 
						GROUP BY `date`, `hour`
						HAVING `date`=DATE(NOW() - INTERVAL 1 DAY) AND `hour`=".$hour_str;
					
					$res1 = mysqli_query($conn, $query);
					$row_cnt = mysqli_num_rows($res1);
					

					$data=0;
					
					while($row = mysqli_fetch_assoc($res1)){
						$data=$row["cnt"];
					}
					
					
					if(count($row_cnt)){
						array_push($daily_product_chart_data,$data);
					} else {
						array_push($daily_product_chart_data,0);
					}
					
					
				}
				date_default_timezone_set('Europe/Berlin');
				
					$prev_date = date("d.m.Y", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
				//echo implode(",", $daily_product_chart_data); 
		?>
		<div class="col-sm-6 col-xs-12 hide">
          <div class="box">
            <div class="box-header">
			  
              <h3 class="box-title">Statistika pregleda proizvoda od 00:00 do 23:59 dana <?php echo $prev_date;?> god.</h3>
            </div>
            <!-- /.box-header -->
			
			
            <div class="box-body table-responsive ">
				<div>
					<canvas id="canvas" height="375" width="600"></canvas>
				</div>
				<script>
var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			labels : ["00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23"],
			datasets : [
				
				{
					label: "My Second dataset",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [<?php echo implode(",", $daily_product_chart_data); ?>
							]
				}
			]

		}

					
				</script>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		<?php } ?>
		<!-- CHART END-->
    </div>
    <div class="row hide" >
    <div class="col-lg-12 col-xs-12">
    	<div id="checkUpdates" class="alert hide">
                <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                <h4><i class="icon fa fa-check"></i> Stanje sistema</h4>
                <span><span>
        </div>
    </div>
    </div>
    </section><!-- /.content -->        
    
		  
	  
		  
		  
		  
    
		

		
</div>
