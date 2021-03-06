<?php
//$user_conf MUST BE INCLUDED BEFORE INCLUDING THIS PAGE 
	$email_msg="<html>";

	$email_msg.="<style>
	table thead tr th{
							display:flex;
							align-items:center;
							justify-content:center;
						}
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
							background-color:#cccccc47!important;	
						}
						table { line-height: 1.2; 
							margin-top: 2pt; margin-bottom: 5pt;
							border-collapse: collapse; 
							width:100%;
							border-bottom: none;
							border-left: none;
							border-right: none;
							}
						
						thead {	font-weight: bold; vertical-align: bottom; background-color:#cccccc47!important;}
						tfoot {	font-weight:  vertical-align: top; }
						thead td { font-weight: bold; background-color:#cccccc47!important;	}
						tfoot td {  }
						
						.headerrow td, .headerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
						.footerrow td, .footerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
						
						tr{
							border-bottom:1px solid #333;
							border-left:1px solid #333;
							border-right:1px solid #333;	
						}
						th {	font-weight: bold; 
							vertical-align: middle; 
							padding-left: 2mm; 
							padding-right: 2mm; 
							padding-top: 0.5mm; 
							padding-bottom: 0.5mm; 
							text-align:center;
							display: flex;
    						align-items: center;
    						justify-content: center;
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
						
						.headerStyle{ padding-top:15px;}
						.headerStyle p{line-height:16px; font-weight:bold;}
						
						tr:nth-child(even){ background-color:#D2D3FF; }
						tr.nobackground{ background-color:transparent; }
						.summaryRow td { font-weight:bold; font-size:12px; border:none !important;}
						.summaryRow { border:none !important;}
				</style>";
	$email_msg.="<body>";
	//SET MEMORANDUM DATA AND HEADER
    $email_msg.='<div class="onethirds">
						<img style="margin:30px 15px 10px 0; max-height:80px; width:100%;" src="'.$user_conf["memorandum_logo"][1].'" />
				</div>
				<div class="twothirds headerStyle">
					<p>'.$user_conf["memorandum_line1"][1].'</p>
					<p>'.$user_conf["memorandum_line2"][1].'</p>
					<p>'.$user_conf["memorandum_line3"][1].'</p>
					<p>'.$user_conf["memorandum_line4"][1].'</p>
					<p>'.$user_conf["memorandum_line5"][1].'</p>
				</div>';
	//SET MEMORANDUM DATA AND HEADER END
	//SET ORDER INFO DATA
	$email_msg.="<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
					".$orderDetailData."
				</div>
				<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
					<div class='twothirds bottomMargin15' style=\"width:66%; float:left; font-size:12px; margin-bottom:15px;\">
						<p>Mesto izdavanja</p>
						<p>".$user_conf["city"][1]."</p>
					</div>
					<div class='onethirds bottomMargin15' style=\"width:33%; float:left; font-size:12px; margin-bottom:15px;\">
						<p>Datum izdavanja</p>
						<p>".date("d.m.Y")."</p>
					</div>
				</div>
				<div style='clear:both;'></div>";

	$email_msg.="<h2 class='titlenumber' style=\"font-weight: bold; font-size: 12pt; color: #000000; font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
	                                             text-align: center;  text-transform:uppercase; page-break-after:avoid; padding-top:10px; padding-bottom:10px; background-color:#FFC4C5;\"
	                                             >".$orderDocumentTypeName."</h2>";

	//SET ORDER INFO DATA END
	//SET TABLE DATA 
	$email_msg.="<table border='1' cellpadding='0' cellspacing='0' style='text-align:right;  line-height: 1.2; margin-top: 2pt; margin-bottom: 5pt;border-collapse: collapse; width:100%;border-bottom: none;border-left: none;border-right: none;width:100%;'>";
	//SET TABLE HEADER
	$email_msg.="<thead>";
	$email_msg.="	<tr class='tableHeder'>";
	$tableHeaderStyle="font-weight: bold; vertical-align: top; padding-left: 2mm; padding-right: 2mm; padding-top: 0.5mm; padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; display: flex; align-items: center; justify-content: center;";
	$email_msg.="		<th style=\"".$tableHeaderStyle."\">R.b.</th>";
	$email_msg.="		<th style=\"".$tableHeaderStyle."\">??ifra.</th>";
	if($user_conf["show_product_picture_in_order_email"][1]=='1'){
	$email_msg.="		<th style=\"".$tableHeaderStyle."\">Slika</th>";
	}
	$email_msg.="		<th style=\"".$tableHeaderStyle."\">Proizvod</th>";
	$email_msg.="		<th style=\"".$tableHeaderStyle."\">Koli??ina</th>";
	$email_msg.="		<th style=\"".$tableHeaderStyle."\"></th>";
	$email_msg.="	</tr>";
	$email_msg.="</thead>";
	//SET TABLE HEADER END
	//SET TABLE BODY
	$email_msg.="<tbody>";
	$tableDataStyle = "padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important; display: flex; align-items: center; justify-content: center;";
	foreach ($orderItems as $key => $orderItem) {
		$email_msg.='<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; background-color:#cccccc47; ">';
		$email_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["sort"].'</td>';
		$email_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["code"].'</td>';
		if($user_conf["show_product_picture_in_order_email"][1]=='1'){
			$email_msg.='	<td style="'.$tableDataStyle.'"><img class="email-image" src="'.BASE_URL.GlobalHelper::getImage('fajlovi/product/'.$orderItem["picture"], 'thumb').'"/></td>';
		}
		$email_msg.='	<td style="'.$tableDataStyle.'"><a href="'.BASE_URL.$orderItem["link"].'" target="_blank">'.$orderItem["name"].'</a> <br /> '.$orderItem["attributes"].'</td>';
		$email_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["quantity"].'</td>';
		$email_msg.='	<td style="'.$tableDataStyle.'">NAPOMENA: Ovaj proizvod je na upit i ne??e se tretirati kao naru??en.</td>';
		$email_msg.="</tr>";
	}
	$email_msg.="</tbody>";
	//SET TABLE BODY END
	$picture_on_off_colspan=5;
	if($user_conf["show_product_picture_in_order_email"][1]=='1'){
		$picture_on_off_colspan=6;
	}
	//SET TABLE FOOTER
	$email_msg.="<tfoot>";
	$email_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$email_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>Uskoro ??ete biti kontaktirani u vezi sa va??im upitom.</td>";
	$email_msg.="	</tr>";
	$email_msg.="</tfoot>";
	//SET TABLE FOOTER END 
	$email_msg.="</table>";
	//SET TABLE DATA END
	//SET FOOTER DATA
	$email_msg.='<p style="width:100%; text-align:center;"></p>';
	//SET FOOTER DATA END
	$email_msg.="</body>";
	$email_msg.="</html>";
?>