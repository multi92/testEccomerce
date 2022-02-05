<?php
//$user_conf MUST BE INCLUDED BEFORE INCLUDING THIS PAGE 
	$pdf_msg="<html>";
	$pdf_msg.="<body>";
	//SET MEMORANDUM DATA AND HEADER
    $pdf_header.='<div class="treethirds">
						<img style="margin:30px auto 30px auto; max-height:100px;  width:1080px;" src="'.$user_conf["memorandum_logo"][1].'" />
				</div>';
				/*<div class="twothirds headerStyle">
					<p>'.$user_conf["memorandum_line1"][1].'</p>
					<p>'.$user_conf["memorandum_line2"][1].'</p>
					<p>'.$user_conf["memorandum_line3"][1].'</p>
					<p>'.$user_conf["memorandum_line4"][1].'</p>
					<p>'.$user_conf["memorandum_line5"][1].'</p>
				</div>';*/


	//SET MEMORANDUM DATA AND HEADER END
	//SET ORDER INFO DATA
	if($emailOrderRecipientDataFlag==1){
	$pdf_msg.="<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
					".$emailOrderCustomerData." ".$emailOrderCommentData."
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
					<div class='treethirds bottomMargin15' style=\"width:99%; float:left; font-size:12px; margin-bottom:15px;\">
						<p>".$emailOrderMemorandumNoticeData."</p>
					</div>
				</div>
				<div style='clear:both;'></div>";
	} else {
		$pdf_msg.="<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
					".$emailOrderCustomerData." ".$emailOrderCommentData."
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
					<div class='treethirds bottomMargin15' style=\"width:99%; float:left; font-size:12px; margin-bottom:15px;\">
						<p>".$emailOrderMemorandumNoticeData."</p>
					</div>
				</div>
				<div style='clear:both;'></div>";
	}

	

	$pdf_msg.="<h2 class='titlenumber' style=\"font-weight: bold; font-size: 12pt; color: #fff; font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
	                                             text-align: center;  text-transform:uppercase; page-break-after:avoid; padding-top:20px; padding-bottom:20px;   background-color:#183961;\"
	                                             >".$orderDocumentTypeName."</h2>";

	//SET ORDER INFO DATA END
	//SET TABLE DATA 
	$pdf_msg.="<table  cellpadding='0' cellspacing='0' style='text-align:right;  line-height: 1.2; margin-top: 2pt; margin-bottom: 5pt;border-collapse: collapse; width:100%;border-top: 1px solid #333; border-bottom: 1px solid #333;border-left: 1px solid #333;border-right: 1px solid #333;width:100%;'>";
	//SET TABLE HEADER
	$pdf_msg.="<thead style='border-bottom: 1px solid #333'>";
	$pdf_msg.="	<tr class='tableHeder'>";
	$tableHeaderStyle="font-weight: bold; vertical-align: top; padding-left: 2mm; padding-right: 2mm; padding-top: 0.5mm; padding-bottom: 0.5mm;text-align:center; border: 1px solid #333; ";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">R.b.</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Proizvod.</th>";
	//$pdf_msg.="		<th style=\"".$tableHeaderStyle."\"></th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Količina</th>";
	//$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Cena</th>";
	//$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Popust</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">VP Cena</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">PDV</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Cena sa PDV-om</th>";
	//$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Ukupno<br />bez PDV-a</th>";
	//
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Ukupno<br />sa PDV-om</th>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="</thead>";
	//SET TABLE HEADER END
	//SET TABLE BODY
	$pdf_msg.="<tbody>";
	$tableDataStyle = "padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:center; font-family: \'Arial\'; font-size:12px!important;	line-height:18px; border: 1px solid #333; ";
	foreach ($orderItems as $key => $orderItem) {
		$pdf_msg.='<tr style="border: 1px solid #333; background-color:transparent; ">';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["sort"].'</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">Šifra: '.$orderItem["code"].' <br /><a href="'.BASE_URL.$orderItem["link"].'" target="_blank">'.$orderItem["name"].'</a> <br /> '.$orderItem["attributes"].' </td>';
		/*$pdf_msg.='	<td style="'.$tableDataStyle.'"><img style="width:50px;height:50px;display: block; max-width: 100%;
    		height: auto; max-height:100%;border: none;" src="'.BASE_URL.GlobalHelper::getImage('fajlovi/product/'.$orderItem["picture"], 'small').'"/></td>';*/
		//$email_msg.='	<td style="'.$tableDataStyle.'"><a href="'.BASE_URL.$orderItem["link"].'" target="_blank">'.$orderItem["name"].'</a> <br /> '.$orderItem["attributes"].'</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["quantity"].'</td>';
		//$email_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["price"],2).' '.$language['moneta'][1].'</td>';
        //$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["item_rebate"],2).'%</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["pricewithrebate"],2).' </td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["taxvalue"],2).'%</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["pricewithrebatewithvat"],2).' </td>';
		//$email_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["itemvalue"],2).' '.$language['moneta'][1].'</td>';
		
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["itemvaluewithvat"],2).' </td>';
		$pdf_msg.="</tr>";
	}
	$pdf_msg.="</tbody>";
	//SET TABLE BODY END
	//SET TABLE FOOTER
	$pdf_msg.="<tfoot>";
	// $pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	// $pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='9'>Ukupno: </td>";
	// $pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>".number_format($calc_totalValue, 2)." ".$language['moneta'][1]."</td>";
	// $pdf_msg.="	</tr>";
	// $pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	// $pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='9'>Popust: </td>";
	// $pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>-".number_format($calc_totalRebateValue, 2)." ".$language['moneta'][1]."</td>";
	// $pdf_msg.="	</tr>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:1px solid #333; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:12px; border-right: 1px solid #333!important;' colspan='6'>Ukupno sa popustom bez PDV-a: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:12px; border:none !important;'>".number_format(round($total_price_pdv,2)-round($total_tax,2), 2, ",", ".")." </td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:1px solid #333; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:12px; border-right: 1px solid #333!important;' colspan='6'>PDV: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:12px; border:none !important;'>+".number_format(round($total_tax,2), 2, ",", ".")."</td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:1px solid #333; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:12px; border-right: 1px solid #333!important;' colspan='6'>Ukupno sa PDV-om: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:12px; border:none !important;'>=".number_format(round($total_price_pdv,2)-$_SESSION['voucher']['value'], 2, ",", ".")."</td>";
	$pdf_msg.="	</tr>";
	
	//$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:1px solid #333; background-color:transparent; \" >";
	//$pdf_msg.="		<td style='text-align:right;  font-size:12px; border-right: 1px solid #333!important;' colspan='6'>Troškovi dostave: </td>";
	//$pdf_msg.="		<td style='text-align:right;  font-size:12px; border:none !important;'>+".number_format($delivery_cost, 2)." </td>";
	//$pdf_msg.="	</tr>";
	$delivery_cost=0;
	
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:1px solid #333; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right; font-weight:bold; font-size:14px; color: #249212; border-right: 1px solid #333!important;' colspan='6'>Ukupno za plaćanje sa PDV-om: </td>";
	$pdf_msg.="		<td style='text-align:right; font-weight:bold; font-size:14px; color: #249212; border:none !important;'>=".number_format(round($total_price_pdv,2)+floatval($delivery_cost), 2, ",", ".")." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="</tfoot>";
	//SET TABLE FOOTER END
	$pdf_msg.="</table>";
	//SET TABLE DATA END
	
	//SET FOOTER DATA
	$pdf_footer='<p style="width:100%; text-align:center;">{PAGENO}</p>';
	//SET FOOTER DATA END
	$pdf_msg.="</body>";
	$pdf_msg.="</html>";
?>