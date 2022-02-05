<?php
//$user_conf MUST BE INCLUDED BEFORE INCLUDING THIS PAGE 
	$pdf_msg="<html>";
	$pdf_msg.="<body>";
	//SET MEMORANDUM DATA AND HEADER
    $pdf_header.='<div class="onethirds">
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
	$pdf_msg.="<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
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

	$pdf_msg.="<h2 class='titlenumber' style=\"font-weight: bold; font-size: 12pt; color: #000000; font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
	                                             text-align: center;  text-transform:uppercase; page-break-after:avoid; padding-top:10px; padding-bottom:10px; background-color:#FFC4C5;\"
	                                             >".$orderDocumentTypeName."</h2>";

	//SET ORDER INFO DATA END
	//SET TABLE DATA 
	$pdf_msg.="<table border='1' cellpadding='0' cellspacing='0' style='text-align:right;  line-height: 1.2; margin-top: 2pt; margin-bottom: 5pt;border-collapse: collapse; width:100%;border-bottom: none;border-left: none;border-right: none;width:100%;'>";
	//SET TABLE HEADER
	$pdf_msg.="<thead>";
	$pdf_msg.="	<tr class='tableHeder'>";
	$tableHeaderStyle="font-weight: bold; vertical-align: top; padding-left: 2mm; padding-right: 2mm; padding-top: 0.5mm; padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; ";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">R.b.</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Šifra.</th>";
	if($user_conf["show_product_picture_in_order_pdf"][1]=='1'){
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Slika</th>";
	}
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Proizvod</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Količina</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Cena</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Popust</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Cena<br />sa popustom</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Ukupno<br />bez PDV-a</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">PDV</th>";
	$pdf_msg.="		<th style=\"".$tableHeaderStyle."\">Ukupno<br />sa PDV-om</th>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="</thead>";
	//SET TABLE HEADER END
	//SET TABLE BODY
	$pdf_msg.="<tbody>";
	$tableDataStyle = "padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;";
	foreach ($orderItems as $key => $orderItem) {
		$pdf_msg.='<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; ">';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["sort"].'</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["code"].'</td>';
		if($user_conf["show_product_picture_in_order_pdf"][1]=='1'){
			$pdf_msg.='	<td style="'.$tableDataStyle.'"><img class="email-image" src="'.BASE_URL.GlobalHelper::getImage('fajlovi/product/'.$orderItem["picture"], 'thumb').'"/></td>';
		}
		$pdf_msg.='	<td style="'.$tableDataStyle.'"><a href="'.BASE_URL.$orderItem["link"].'" target="_blank">'.$orderItem["name"].'</a> <br /> '.$orderItem["attributes"].'</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.$orderItem["quantity"].' x </td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["price"],2).' '.$language['moneta'][1].'</td>';
        $pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["item_rebate"],2).'%</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["pricewithrebate"],2).' '.$language['moneta'][1].'</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["itemvalue"],2).' '.$language['moneta'][1].'</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["taxvalue"],2).'%</td>';
		$pdf_msg.='	<td style="'.$tableDataStyle.'">'.number_format($orderItem["itemvaluewithvat"],2).' '.$language['moneta'][1].'</td>';
		$pdf_msg.="</tr>";
	}
	$pdf_msg.="</tbody>";
	//SET TABLE BODY END
	$picture_on_off_colspan=9;
	if($user_conf["show_product_picture_in_order_pdf"][1]=='1'){
		$picture_on_off_colspan=10;
	}
	//SET TABLE FOOTER
	$pdf_msg.="<tfoot>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>Ukupno: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>".number_format($calc_totalValue, 2)." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>Popust: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>-".number_format($calc_totalRebateValue, 2)." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>Ukupno sa popustom bez PDV-a: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>".number_format($calc_totalValueWithRebate, 2)." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>PDV: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>+".number_format($calc_totalValueWithRebateVatValue, 2)." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	if($delivery_cost>0){
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>Troškovi dostave: </td>";
	$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>+".number_format($delivery_cost, 2)." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	}
	if($voucher_value > 0){
		$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
		$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;' colspan='".$picture_on_off_colspan."'>Iznos vaučera: </td>";
		$pdf_msg.="		<td style='text-align:right;  font-size:10px; border:none !important;'>- ".number_format($voucher_value, 2)." ".$language['moneta'][1]."</td>";
		$pdf_msg.="	</tr>";
	}	
	
	$pdf_msg.="	<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >";
	$pdf_msg.="		<td style='text-align:right; font-weight:bold; font-size:12px; color: #249212; border:none !important;' colspan='".$picture_on_off_colspan."'>Ukupno za plaćanje sa PDV-om: </td>";
	$pdf_msg.="		<td style='text-align:right; font-weight:bold; font-size:12px; color: #249212; border:none !important;'>".number_format($calc_totalValueWithRebateWithVat-$voucher_value+$delivery_cost, 2)." ".$language['moneta'][1]."</td>";
	$pdf_msg.="	</tr>";
	$pdf_msg.="</tfoot>";
	//SET TABLE FOOTER END
	$pdf_msg.="</table>";
	//SET TABLE DATA END
	if($_SESSION['offer']['paymenttype']=='u'){ 
		$oTotal=number_format($calc_totalValueWithRebateWithVat-$voucher_value+$delivery_cost, 2);
		if($user_conf["free_delivery_from"][1]>0 && $oTotal>=$user_conf["free_delivery_from"][1]){
			$pdf_msg.='<br><br><p style="width:100%; text-align:center; font-size:16px;"><b>Molimo vas da uplatu od '.number_format($calc_totalValueWithRebateWithVat, 2).' '.$language['moneta'][1].' izvršite na tekući račun:'.$user_conf["payment slip_bank_account"][1].' ,
			Svrha uplate: "'.$user_conf["payment slip_purpose_of_payment"][1].''.$order_number.'", Primalac: '.$user_conf["company"][1].' '.$user_conf["city"][1].' 
		</b></p>';
		$pdf_msg.='<br><br><p style="width:100%; text-align:center; font-size:12px;"><b>'.$user_conf["footnote_free_delivery"][1].'</b></p>';
		}else{
			$pdf_msg.='<br><br><p style="width:100%; text-align:center; font-size:16px;"><b>Molimo vas da uplatu od '.number_format($calc_totalValueWithRebateWithVat, 2).' '.$language['moneta'][1].' izvršite na tekući račun:'.$user_conf["payment slip_bank_account"][1].' ,
			Svrha uplate: "'.$user_conf["payment slip_purpose_of_payment"][1].''.$order_number.'", Primalac: '.$user_conf["company"][1].' '.$user_conf["city"][1].' 
		</b></p>';
		$pdf_msg.='<br><br><p style="width:100%; text-align:center; font-size:12px;"><b>'.$user_conf["footnote_delivery_cost"][1].'</b></p>';
		}

	} else {
		$oTotal=number_format($calc_totalValueWithRebateWithVat-$voucher_value+$delivery_cost, 2);
		if($user_conf["free_delivery_from"][1]>0 && $oTotal>=$user_conf["free_delivery_from"][1]){
			$pdf_msg.='<br><br><p style="width:100%; text-align:center; font-size:12px;"><b>'.$user_conf["footnote_free_delivery"][1].'</b></p>';
		}else{
			$pdf_msg.='<br><br><p style="width:100%; text-align:center; font-size:12px;"><b>'.$user_conf["footnote_delivery_cost"][1].'</b></p>';
		}
	}
	//SET FOOTER DATA
	$pdf_footer='<p style="width:100%; text-align:center;">{PAGENO}</p>';
	//SET FOOTER DATA END
	$pdf_msg.="</body>";
	$pdf_msg.="</html>";
?>