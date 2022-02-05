<?php
$class_version["invoice"] = array('module', '1.0.0.0.1', 'Nema opisa');

class Invoice{
	
	public static function getInvoiceHeaderInformation(){
		$payment = '';//$_SESSION['ordering_address']['payment'];
        $partner_info = '';

        $userdetails = "<br /> Detalji narucioca: <br />
		<br />Email:  ".$_SESSION['email']."
		<br />Ime : ".$_SESSION['ime']."
		<br />Prezime : ".$_SESSION['prezime']."
		<br />Adresa : ".$_SESSION['adresa'].", ".$_SESSION['postbr']." , ".$_SESSION['mesto']."
		<br />Telefon : ".$_SESSION['telefon']."
		<br /><br />";
		$userdetails .= "<br/>Placanje: ".$payment."<br/>";
		
        if(isset($_SESSION['type']) && $_SESSION['type'] == 'partner'){
            $partner = GlobalHelper::getPartnerInfo($_SESSION['id']);
            $partner_info = "<br/>Detalji partnera: <br/>
                    <br />Partner : ".$partner['name']."
                    <br />PIB : ".$partner['code']."
                    <br />Adresa : ".$partner['address'].", ".$partner['zip']." , ".$partner['city']."
                    <br />Fax : ".$partner['fax']."
                    <br />Telefon : ".$partner['phone']."
            		<br />Email:  ".$partner['email']."
                    <br /><br />";
			$userdetails = $partner_info;
        }
		return $userdetails; 
	}
	
	public static function getInvoiceMsg($userdetails='',$reservation_number='',$shop_table_body='',$total_norebateprice=0,$total_norebateprice_pdv=0,$total_rebate=0,$total_rebate_pdv=0,$total_price=0,$total_price_pdv=0,$type=''){
		$msg = '';

            $msg .= "<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
							".$userdetails."
						</div>
						<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
							<div class='twothirds bottomMargin15' style=\"width:66%; float:left; font-size:12px; margin-bottom:15px;\">
								<p>Mesto izdavanja</p>
								<p>Nis</p>
							</div>
							<div class='onethirds bottomMargin15' style=\"width:33%; float:left; font-size:12px; margin-bottom:15px;\">
								<p>Datum izdavanja</p>
								<p>".date("d.m.Y")."</p>
							</div>
							
						</div>
						<div style='clear:both;'></div>
						
						<h2 class='titlenumber' style=\"font-weight: bold; font-size: 12pt; color: #000000; 
	font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
	text-align: center;  text-transform:uppercase; page-break-after:avoid; 
	padding-top:10px; padding-bottom:10px; background-color:#FFC4C5;\">Rezervacija ".$type.'-'.$reservation_number."</h2>


                        <table border='1' cellpadding='0' cellspacing='0' style='text-align:right;  line-height: 1.2; 
	margin-top: 2pt; margin-bottom: 5pt;
	border-collapse: collapse; 
	width:100%;
	border-bottom: none;
	border-left: none;
	border-right: none;
	width:100%;'>
                                                <thead>
													<tr class='tableHeder' >
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; \">R.b.</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Šifra</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Proizvod</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Jed. <br /> mere</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Količina</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Cena </th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Cena sa <br /> PDV </th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Rabat (%)</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Vrednost</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Vrednost <br /> sa PDV</th> 
													</tr>
                                                </thead>
                                                <tbody>".$shop_table_body."</tbody>

            <tfoot>
				<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;' colspan='2'>Ukupno: </td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_norebateprice, 2)."</td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_norebateprice_pdv, 2)."</td>
				</tr>
				<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \">
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;' colspan='2'>Rabat: </td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_rebate, 2)."</td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_rebate_pdv, 2)."</td>
				</tr>
				<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \">
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;' colspan='2'>Ukupno sa rabatom: </td>
				  <td style='font-weight:bold; font-size:12px; border:none !important;'></td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_price, 2)."</td>
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_price_pdv, 2)."</td>
				</tr>
            </tfoot>
            </table><br /><br />
			</body>
			</html>";
			
		return $msg; 
	}
	
	
	
	
}
?>