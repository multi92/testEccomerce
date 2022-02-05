<html>
	<head>
    	<meta charset="utf-8" />
    	<base href="/" />
    	
			<style>
				body { font-family: 'Arial'; font-size:11px !important;	line-height:12px;  }
				p { 	text-align: justify; margin-bottom: 0; margin-top:0pt;  }
				
				p.headtext{
					font-size:12px;
					line-height:8px;
					font-weight:bold;	
				}
				.tableHeder th{
					padding:5px 2px;
					color:#000 !important;	
				}
				table { line-height: 1.2; 
					margin-top: 2pt; margin-bottom: 5pt;
					border-collapse: collapse; 
					width:100%;
					border-bottom: none;
					border-left: none;
					border-right: none;
					}
				
				thead {	font-weight: bold; vertical-align: bottom; }
				tfoot {	font-weight: bold; vertical-align: top; }
				thead td { font-weight: bold; }
				tfoot td { font-weight: bold; }
				
				.headerrow td, .headerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
				.footerrow td, .footerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
				
				tr{
					border-bottom:1px solid #333;
					border-left:1px solid #333;
					border-right:1px solid #333;	
				}
				th {	font-weight: bold; 
					vertical-align: top; 
					padding-left: 2mm; 
					padding-right: 2mm; 
					padding-top: 0.5mm; 
					padding-bottom: 0.5mm; 
					text-align:center;
				 }
				
				td {	padding-left: 1mm; 
					vertical-align: middle; 
					padding-right: 1mm; 
					padding-top: 1mm; 
					padding-bottom: 1mm;
					text-align:right;
					font-family: 'Arial'; font-size:11px !important;	line-height:12px;
					border-left:1px solid #333 !important;
					border-right:1px solid #333 !important;
				 }
				
				th p { margin:0pt;  }
				td p { margin:0pt;  }
				
				table.widecells td {
					padding-left: 5mm;
					padding-right: 5mm;
				}
				table.tallcells td {
					padding-top: 3mm;
					padding-bottom: 3mm; 
				}
				
				hr {	width: 70%; height: 1px; 
					text-align: center; color: #999999; 
					margin-top: 8pt; margin-bottom: 8pt; }
				
				a {	color: #000066; font-style: normal; text-decoration: underline; 
					font-weight: normal; }
				
				pre { font-family: 'DejaVu Sans Mono'; font-size: 9pt; margin-top: 5pt; margin-bottom: 5pt; }
				
				h1 {	font-weight: normal; font-size: 22pt; color: #000; 
					font-family: ''; margin-top: 0; margin-bottom: 0; 
					 
					text-align: center ; page-break-after:avoid; }
					
				h2 {	font-weight: bold; font-size: 12pt; color: #000000; 
					font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
					text-align: center;  text-transform:uppercase; page-break-after:avoid; 
					padding-top:10px; padding-bottom:10px; background-color:#FFC4C5;}
					
				h3 {	font-weight: normal; font-size: 26pt; color: #000000; 
					font-family: 'DejaVu Sans Condensed'; margin-top: 0pt; margin-bottom: 6pt; 
					border-top: 0; border-bottom: 0; 
					text-align: ; page-break-after:avoid; }
				
				
				
				.bottomMargin15{ margin-bottom:15px; }
				
				.half{ width:50%; float:left; font-size:12px !important; line-height:14px; }
				.half p {  }
				.twothirds{ width:66%; float:left; font-size:12px; }
				.onethirds{ width:33%; float:left; font-size:12px; }
				.hrline{ width:100%; margin:20px 0; height:1px; }
				
				.headerStyle{ padding-top:15px; }
				.headerStyle p{line-height:16px; font-weight:bold;}
				
				tr:nth-child(even){ background-color:#D2D3FF; }
				tr.nobackground{ background-color:transparent; }
				.summaryRow td { font-weight:bold; font-size:12px; border:none !important;}
				.summaryRow { border:none !important;}
			</style>
        
    </head>
    <body>
		
		<?php 
		
			include_once("../../../config/db_config.php");
			include_once($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");  
			include_once($_SERVER['DOCUMENT_ROOT']."/".$system_conf['theme_path'][1]."config/user.configuration.php");

			$q = "SELECT di.rebate, di.price, di.taxvalue, di.productname, p.code, dia.quantity, dia.attrvalue, d.*, c.value as couponvalue, dd.customeremail AS email, dd.* 
				FROM b2c_documentitemattr dia
				LEFT JOIN b2c_documentitem di ON dia.b2c_documentitemid = di.id
				LEFT JOIN b2c_document d ON di.b2c_documentid = d.id
				LEFT JOIN b2c_documentdetail AS dd ON di.b2c_documentid = d.id
				LEFT JOIN product p ON di.productid = p.id
				LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
				LEFT JOIN coupons c ON uc.couponsid = c.id
				WHERE dia.status != 'd' AND di.b2c_documentid = ".$_GET['docid'];
			
			$re = mysqli_query($conn, $q);
			
			$data = array();
			if(mysqli_num_rows($re) > 0){
				while($row = mysqli_fetch_assoc($re)){
					array_push($data, $row);
				}
			}
				
		?>
		
		<div class="onethirds">
			<img style="margin:20px 15px 10px 0; max-height:80px; width:auto;" src="<?php echo BASE_URL.$user_conf['memorandum_logo'][1]; ?>" />
		</div>
		<div class="twothirds headerStyle">
			<p><?php echo $user_conf["memorandum_line1"][1]; ?></p>
			<p><?php echo $user_conf["memorandum_line2"][1]; ?></p>
			<p><?php echo $user_conf["memorandum_line3"][1]; ?></p>
			<p><?php echo $user_conf["memorandum_line4"][1]; ?></p>
			<p><?php echo $user_conf["memorandum_line5"][1]; ?></p>
		</div>
		<div style="clear:both;"></div>
		<div class="x_half" style="width:50%; float:left; font-size:12px!important; line-height:14px">
			<br>
			<br>
			Email: <?php echo $data[0]['email']; ?> <br>
			Ime : <?php echo $data[0]['customername']; ?> <br>
			Prezime : <?php echo $data[0]['customerlastname']; ?> <br>
			Adresa : <?php echo $data[0]['customeraddress']; ?>, <?php echo $data[0]['customerzip']; ?> , <?php echo $data[0]['customercity']; ?> <br>
			Telefon : <?php echo $data[0]['customerphone']; ?> <br>
			Način plaćanja : <?php echo ($data[0]['payment'] == 'poz')? 'pouzećem':'karticom'; ?> <br>
		</div>
		
		<div class="x_half" style="width:50%; float:left; font-size:12px!important; line-height:14px">
			<div class="x_twothirds x_bottomMargin15" style="width:66%; float:left; font-size:12px; margin-bottom:15px">
			<br>
			<br>
				<p>Mesto izdavanja</p>
				<p>Niš</p>
			<br>
				<p>Datum izdavanja</p>
				<p><?php  $docdate=date_create($data[0]['documentdate']); echo date_format($docdate,"d.m.Y"); ?></p>
			</div>
			<div class="x_onethirds x_bottomMargin15" style="width:33%; float:left; font-size:12px; margin-bottom:15px">
				<p></p>
				<p></p>
			</div>
		</div>
		<div style="clear:both"></div>
		<h2 class="x_titlenumber" style="font-weight:bold; font-size:12pt; color:#FFF; font-family:'Arial'; margin-top:20px; margin-bottom:20px; border:none; text-align:center; text-transform:uppercase; page-break-after:avoid; padding-top:10px; padding-bottom:10px; background-color:#000">
Račun broj: <?php echo $data[0]['number']; ?></h2>
		
		<table border="1" cellpadding="0" cellspacing="0" style="text-align:right; line-height:1.2; margin-top:2pt; margin-bottom:5pt; border-collapse:collapse; width:100%; border-bottom:none; border-left:none; border-right:none; width:100%">
			<thead>
				<tr class="x_tableHeder">
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					R.b.</th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Šifra</th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Proizvod</th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Količina</th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Cena </th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Popust (%)</th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Vrednost <br>
					bez PDV</th>
					<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					Vrednost <br>
					sa PDV</th>
				</tr>
			</thead>
			<tbody>
			
			<?php $i = 1; 
				$totalamount_notax = 0;
				$totalamount = 0;
				foreach($data as $key=>$val){ 
			
				$val['attrvalue'] = json_decode($val['attrvalue'], true);
			?>
				<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo $i; ?></td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo $val['code']; ?></td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo $val['productname']; ?> <br>
					mass: <?php echo $val['attrvalue']['mass']; ?><br>
					boja: <?php echo $val['attrvalue']['boja']; ?><br>
					veličina: <?php echo $val['attrvalue']['veličina']; ?><br>
					</td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo $val['quantity']; ?></td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo number_format($val['price']*((100+$val['taxvalue'])*0.01), 2, '.', ','); ?></td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo $val['rebate']; ?></td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo number_format($val['price']*((100-$val['rebate'])*0.01)*$val['quantity'], 2, '.', ','); ?></td>
					<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:'Arial'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
					<?php echo number_format($val['price']*((100+$val['taxvalue'])*0.01)*((100-$val['rebate'])*0.01)*$val['quantity'], 2, '.', ','); ?></td>
				</tr>
			<?php 
					$totalamount_notax += (floatval($val['price'])*((100-floatval($val['rebate']))*0.01)*floatval($val['quantity']));
					$totalamount += (floatval($val['price'])*((100+floatval($val['taxvalue']))*0.01)*((100-floatval($val['rebate']))*0.01)*floatval($val['quantity']));
			
					$i++; 
				} 
				
				
			?>
			
			</tbody>
			<tfoot>
				<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
				<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				Ukupno: </td>
				<td style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				<?php echo number_format($totalamount_notax, 2, '.', ','); ?></td>
				<td style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				<?php echo number_format($totalamount, 2, ',','.'); ?></td>
				</tr>
				<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
				<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				Troškovi dostave : </td>
				<td colspan="2" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				<?php if($totalamount < 5000) {echo '250.00'; $totalamount = (floatval($totalamount)+250);} else echo '0.00'; ?></td>
				</tr>
                <tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
				<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				Kupon : </td>
				<td colspan="2" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				<?php if($data[0]['usedcouponid'] > '') {echo "-".$data[0]['couponvalue']; } else echo '0.00'; ?></td>
				</tr>
                
				<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
				<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
                
                
                <?php 
				
					if($data[0]['usedcouponid'] > ''){
						$totalamount = floatval($totalamount)-floatval($data[0]['couponvalue']);
					}
							 ?>
				Ukupno za uplatu: </td>
				<td colspan="2" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
				<?php echo number_format($totalamount, 2, ',','.'); ?></td>
				</tr>
			</tfoot>
		</table>
		
		<br /><br />
			U SLUČAJU POTREBE ZA REKLAMACIJOM MOLIMO VAS DA NA NAŠEM SAJTU PRVO PROČITATE PRAVILNIK O POSTUPKU I NAČINU REŠAVANJA REKLAMACIJE TAKODJE , NA NAŠEM SAJTU IMATE I POTREBNA DOKUMENTA U PDF FORMATU ZA PODNOŠENJE REKLAMACIJE.
			<br /><br />
			RAČUN JE AUTOMATSKI KREIRAN I VALIDAN JE BEZ PEČATA I POTPISA.
			<br /><br />
			<br /><br />
			<p>
				FAKTURISAO <br />
				___________________
				<span style='    margin-left: 35%;'> M.P. </span>
			</p>
				
		<script type="text/javascript">
			window.print(); 
		</script>
    </body>
</html>   