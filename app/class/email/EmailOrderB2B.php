<?php
    $email_msg='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="viewport" content="width=1000, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title></title>
    <style type="text/css" rel="stylesheet" media="all">
    /* Base ------------------------------ */
    
    @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
    body {
      width: 100% !important;
      height: 100%;
      margin: 0;
      -webkit-text-size-adjust: none;
    }
    
    a {
      color: #3869D4;
    }
    
    a img {
      border: none;
    }
    
    td {
      word-break: break-word;
    }
    
    .preheader {
      display: none !important;
      visibility: hidden;
      mso-hide: all;
      font-size: 1px;
      line-height: 1px;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
    }
    /* Type ------------------------------ */
    
    body,
    td,
    th {
      font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
    }
    
    h1 {
      margin-top: 0;
      color: #333333;
      font-size: 22px;
      font-weight: bold;
      text-align: left;
    }
    
    h2 {
      margin-top: 0;
      color: #333333;
      font-size: 16px;
      font-weight: bold;
      text-align: left;
    }
    
    h3 {
      margin-top: 0;
      color: #333333;
      font-size: 14px;
      font-weight: bold;
      text-align: left;
    }
    
    td,
    th {
      font-size: 16px;
    }
    
    p,
    ul,
    ol,
    blockquote {
      margin: .4em 0 1.1875em;
      font-size: 16px;
      line-height: 1.625;
    }
    
    p.sub {
      font-size: 13px;
    }
    /* Utilities ------------------------------ */
    
    .align-right {
      text-align: right;
    }
    
    .align-left {
      text-align: left;
    }
    
    .align-center {
      text-align: center;
    }
    /* Buttons ------------------------------ */
    .button--fullwidth {
      width:100%;
       background-color: #183961;
       color:#ffffff;

     }
    .button {

      background-color: #183961;
      border-top: 10px solid #183961;
      border-right: 18px solid #183961;
      border-bottom: 10px solid #183961;
      border-left: 18px solid #183961;
      display: inline-block;
      color: #FFF;
      text-decoration: none;
      border-radius: 3px;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
      -webkit-text-size-adjust: none;
      box-sizing: border-box;
    }
    
    .button--green {
      background-color: #22BC66;
      border-top: 10px solid #22BC66;
      border-right: 18px solid #22BC66;
      border-bottom: 10px solid #22BC66;
      border-left: 18px solid #22BC66;
    }
    
    .button--red {
      background-color: #FF6136;
      border-top: 10px solid #FF6136;
      border-right: 18px solid #FF6136;
      border-bottom: 10px solid #FF6136;
      border-left: 18px solid #FF6136;
    }
    
    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
        text-align: center !important;
      }
    }
    /* Attribute list ------------------------------ */
    
    .attributes {
      margin: 0 0 21px;
    }
    
    .attributes_content {
      background-color: #F4F4F7;
      padding: 16px;
    }
    
    .attributes_item {
      padding: 0;
    }
    /* Related Items ------------------------------ */
    
    .related {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .related_item {
      padding: 10px 0;
      color: #CBCCCF;
      font-size: 15px;
      line-height: 18px;
    }
    
    .related_item-title {
      display: block;
      margin: .5em 0 0;
    }
    
    .related_item-thumb {
      display: block;
      padding-bottom: 10px;
    }
    
    .related_heading {
      border-top: 1px solid #CBCCCF;
      text-align: center;
      padding: 25px 0 10px;
    }
    /* Discount Code ------------------------------ */
    
    .discount {
      width: 100%;
      margin: 0;
      padding: 24px;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
      border: 2px dashed #CBCCCF;
    }
    
    .discount_heading {
      text-align: center;
    }
    
    .discount_body {
      text-align: center;
      font-size: 15px;
    }
    /* Social Icons ------------------------------ */
    
    .social {
      width: auto;
    }
    
    .social td {
      padding: 0;
      width: auto;
    }
    
    .social_icon {
      height: 20px;
      margin: 0 8px 10px 8px;
      padding: 0;
    }
    /* Data table ------------------------------ */
    
    .purchase {
      width: 100%;
      margin: 0;
      padding: 35px 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_content {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_item {
      padding: 10px 0;
      color: #51545E;
      font-size: 15px;
      line-height: 18px;
    }
    
    .purchase_heading {
      padding-bottom: 8px;
      border-bottom: 1px solid #cccccc;
    }
    
    .purchase_heading p {
      margin: 0;
      color: #85878E;
      font-size: 12px;
    }
    
    .purchase_footer {
      padding-top: 5px;
      padding-left:5px;
      padding-right:5px;
      border-top: 1px solid #cccccc;
    }
    
    .purchase_total {
      margin: 0;
      text-align: right;
      font-weight: bold;
      color: #333333;
    }
    
    .purchase_total--label {
      padding: 0 15px 0 0;
    }
    
    body {
      background-color: #F4F4F7;
      color: #51545E;
    }
    
    p {
      color: #51545E;
    }
    
    p.sub {
      color: #6B6E76;
    }
    
    .email-wrapper {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
    }
    
    .email-content {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    /* Masthead ----------------------- */
    
    .email-masthead {
      padding: 25px 0;
      text-align: center;
    }
    
    .email-masthead_logo {
      width: 94px;
    }
    
    .email-masthead_name {
      font-size: 16px;
      font-weight: bold;
      color: #A8AAAF;
      text-decoration: none;
      text-shadow: 0 1px 0 white;
    }
    /* Body ------------------------------ */
    
    .email-body {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-body_inner {
      width: 100%;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-footer {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .email-footer p {
      color: #6B6E76;
    }
    
    .body-action {
      width: 100%;
      margin: 30px auto;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .body-sub {
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid #cccccc;
    }
    
    .content-cell {
      padding: 35px;
    }
    /*Media Queries ------------------------------ */
    
    @media only screen and (max-width: 600px) {
      .email-body_inner,
      .email-footer {
        width: 1000px !important;
      }
    }
    
    @media (prefers-color-scheme: dark) {
      body,
      .email-body,
      .email-body_inner,
      .email-content,
      .email-wrapper,
      .email-masthead,
      .email-footer {
        background-color: #333333 !important;
        color: #FFF !important;
      }
      p,
      ul,
      ol,
      blockquote,
      h1,
      h2,
      h3,
      span,
      .purchase_item {
        color: #FFF !important;
      }
      .attributes_content,
      .discount {
        background-color: #222 !important;
      }
      .email-masthead_name {
        text-shadow: none !important;
      }
    }
    
    :root {
      color-scheme: light dark;
      supported-color-schemes: light dark;
    }
    </style>
    <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
  </head>
  <body>
    <span class="preheader"></span>
    <table class="email-wrapper" width="1000" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="1000" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead">
                <a href="'.BASE_URL.'" class="f-fallback email-masthead_name">
                	<img style="width: 100%!important;" src="'.BASE_URL.$user_conf["memorandum_logo"][1].'" />
              	</a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="1000" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
              <strong>Mesto izdavanja: </strong>'.$user_conf["city"][1].'
            </span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
              <strong>Datum izdavanja: </strong>'.date("d.m.Y").'
            </span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>';
                         
            
          if($emailOrderRecipientDataFlag==1){
          $email_msg.=''; 

              $email_msg.=' <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td width="33%" class="attributes_item">
                                    <span class="f-fallback">
                            '.$emailOrderCustomerData.'
                        </span>
                                  </td>
                                  <td width="33%" class="attributes_item">
                                    <span class="f-fallback"><br />
                            '.'<br /><br /><br />
                         </span>
                                  </td>
                                
                                  <td width="33%" class="attributes_item">
                                    <span class="f-fallback">
                            '.'<br /><br /><br />
                         </span>
                                  </td>

                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>';             
           

           } else {
              $email_msg.=' <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td width="50%" class="attributes_item">
                                    <span class="f-fallback">
                            '.$emailOrderCustomerData.'
                        </span>
                                  </td>
                                
                                  <td width="50%" class="attributes_item">
                                    <span class="f-fallback">
                            '.'<br /><br /><br />
                         </span>
                                  </td>

                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>';
           }


           $email_msg.='<p>'.$emailOrderCommentData.'</p>';
           $email_msg.='<p>'.$emailOrderMemorandumNoticeData.'</p>
                        
                        <!-- Action -->
                        <table class="body-action" align="center" width="1000px" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <!-- Border based button
           https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation" style="background-color: #183961;color:#ffffff;">
                                <tr>
                                  <td align="center">
                                    <span class="f-fallback button button--fullwidth" style="width:100%;background-color: #183961;color:#ffffff;">'.$orderDocumentTypeName.'</span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <table class="purchase" width="1000px" cellpadding="0" cellspacing="0">
                          <tr>
                            <td colspan="2">
                              <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">R.b.</p>
                                  </th>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">Proizvod</p>
                                  </th>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">Količina</p>
                                  </th>
                                  
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">VP Cena</p>
                                  </th>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">PDV</p>
                                  </th>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">Cena sa PDV-om</p>
                                  </th>
                                  
                                  <th class="purchase_heading" align="right">
                                    <p class="f-fallback">Ukupno sa PDV-om</p>
                                  </th>
                                </tr>';
                                foreach ($orderItems as $key => $orderItem) {
                                 $email_msg.='<tr style="border-bottom:1px solid #cccccc;">';
                                  	 $email_msg.='<td width="5%" class="purchase_item"><span class="f-fallback">'.$orderItem["sort"].'</span></td>';
                                  	 $email_msg.='<td width="35%" class="purchase_item"><span class="f-fallback">Šifra-'.$orderItem["code"].' <br /><a href="'.BASE_URL.$orderItem["link"].'" target="_blank">'.$orderItem["name"].'</a> <br /> '.$orderItem["attributes"].' </span></td>';
                                  	 $email_msg.='<td width="10%" class="purchase_item"><span class="f-fallback">'.$orderItem["quantity"].'</span></td>';
                                  	 
                                  	 $email_msg.='<td width="10%" class="purchase_item"><span class="f-fallback">'.number_format(round($orderItem["pricewithrebate"],2),2).'</span></td>';
                                  	 $email_msg.='<td width="10%" class="purchase_item"><span class="f-fallback">'.number_format($orderItem["taxvalue"],2).'%</span></td>';
                                     $email_msg.='<td width="10%" class="purchase_item"><span class="f-fallback">'.number_format(round($orderItem["pricewithrebatewithvat"],2),2).'</span></td>';
                                     
                                  	 $email_msg.='<td width="20%" class="purchase_item align-right" align="right" ><span class="f-fallback">'.number_format(round($orderItem["itemvaluewithvat"],2),2).'</span></td>';
                                 $email_msg.='</tr>';
                                }


                            $email_msg.='</table>';
                            $email_msg.='<table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">';
                                $email_msg.='<tr>
                                  				<td width="80%" class="purchase_footer" valign="middle">
                                  				  <p class="f-fallback purchase_total purchase_total--label">Ukupno bez PDV-a: </p>
                                  				</td>
                                  				<td width="20%" class="purchase_footer" valign="middle" style="text-align:right;">
                                  				  <p class="f-fallback purchase_total">'.number_format(round($total_price_pdv,2)-round($total_tax,2), 2, ",", ".").'</p>
                                  				</td>
                                			</tr>';
                               	$email_msg.='<tr>
                                  				<td width="80%" class="purchase_footer" valign="middle">
                                  				  <p class="f-fallback purchase_total purchase_total--label">PDV: </p>
                                  				</td>
                                  				<td width="20%" class="purchase_footer" valign="middle" style="text-align:right;">
                                  				  <p class="f-fallback purchase_total">+'.number_format(round($total_tax,2), 2, ",", ".").'</p>
                                  				</td>
                                			</tr>';
                                //$email_msg.='<tr style="background-color: #eeeeee;">
                                //          <td width="80%" class="purchase_footer" valign="middle">
                                //            <p class="f-fallback purchase_total purchase_total--label">Ukupno sa PDV-om: </p>
                                //          </td>
                                //          <td width="20%" class="purchase_footer" valign="middle" style="text-align:right;">
                                //            <p class="f-fallback purchase_total">'.number_format(round($total_price_pdv,2)-$_SESSION['voucher']['value'], 2, ",", ".")." ".$language['moneta'][1].'</p>
                                //          </td>
                                //      </tr>';
                                $delivery_cost=0;
                                if($delivery_cost>0){
                               	$email_msg.='<tr style="background-color: #eeeeee;">
                                  				<td width="80%" class="purchase_footer" valign="middle">
                                  				  <p class="f-fallback purchase_total purchase_total--label">Troškovi dostave: </p>
                                  				</td>
                                  				<td width="20%" class="purchase_footer" valign="middle" style="text-align:right;">
                                  				  <p class="f-fallback purchase_total">+'.number_format(round($delivery_cost,2), 2, ",", ".").'</p>
                                  				</td>
                                			</tr>';
                                }
								
                                $email_msg.='<tr style="background-color: #cccccc;">
                                  				<td width="80%" class="purchase_footer" valign="middle">
                                  				  <p class="f-fallback purchase_total purchase_total--label"><b>Ukupno za plaćanje sa PDV-om: </b></p>
                                  				</td>
                                  				<td width="20%" class="purchase_footer" valign="middle" style="text-align:right;">
                                  				  <p class="f-fallback purchase_total"><b>'.number_format(round($total_price_pdv,2)+floatval($delivery_cost), 2, ",", ".")." ".$language['moneta'][1].'</b></p>
                                  				</td>
                                			</tr>';

                              $email_msg.='</table>
                            </td>
                          </tr>
                        </table>
                        <p></p>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell" align="center">
                      <p class="f-fallback sub align-center">&copy; 2020 '.$user_conf["company"][1].' Sva prava zadržana.</p>
                      <p class="f-fallback sub align-center">
                        '.$user_conf["company"][1].'
                        <br>'.$user_conf["address"][1].', '.$user_conf["zip"][1].', '.$user_conf["city"][1].'.
                        <br>'.$user_conf["phone"][1].'
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
//$user_conf MUST BE INCLUDED BEFORE INCLUDING THIS PAGE 
	
?>