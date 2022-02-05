
    <div class="top-menu">
    <div class="container header-container">
        <div class="row">
            <div class="col-xs-12 top-menu-col col-seter">
                <ul class="top-menu-left-ul -user-part" >
                    <?php if(isset($_SESSION['partnerid']) && $_SESSION['partnerid']>0){ ?>
                    <li ><a href="commercialist_select_partner"  title="<?php  echo $language["commercialist_header_bar"][1]; //Promenite partnera?>"><i class="material-icons" style="font-size: 18px;vertical-align: middle; padding-left:3px;">group</i> <?php  echo $language["commercialist_header_bar"][1];?></a></li>
                    <li ><a href="partnerinfo"  title="<?php  echo $language["commercialist_header_bar"][3]." ".$commercialistpartnerinfo["name"]; //Ulogovani ste kao?>" > <span><?php  echo $language["commercialist_header_bar"][3];?> <?php echo $commercialistpartnerinfo["name"] ?></span> </a></li>
                     <?php } else {?>
                    <li ><a href="commercialist_select_partner"  title="<?php  echo $language["commercialist_header_bar"][2]; //Odaberite partnera?>"><i class="material-icons" style="font-size: 18px;vertical-align: middle; padding-left:3px;">group</i> <?php  echo $language["commercialist_header_bar"][2];?></a></li>
                    <?php }?>
                    <?php if(isset($_SESSION['partneraddressid']) && $_SESSION['partneraddressid']>0){ ?>
                        <li ><a href="partneraddressinfo"  title="<?php  echo $language["commercialist_header_bar"][4]; //Objekat?>" > <span><?php  echo $language["commercialist_header_bar"][4]; //Objekat?>: <?php echo $commercialistpartneraddressinfo["objectname"].", ".$commercialistpartneraddressinfo["address"]; ?></span> </a></li>
                    <?php }?>
                    <?php if(isset($_SESSION['partnerid']) && $_SESSION['partnerid']>0){ ?>
                        <li ><a class="commercialist_remove_select_partnerBTN"  title="Uklonite partnera"><i class="material-icons" style="font-size: 18px;vertical-align: middle; padding-left:3px; color:red;">close</i></a></li>
                     <?php }?>
                </ul>
                
            </div>
        </div>
    </div> 
    </div>    
