<div class="main-body-filter"></div>


    <div class="slide-menu">
        <div class="head">
            <i class="icons jq_leftMenuBackBtn -back"></i>
            <h2 class="title">Kategorije</h2>
            <i class="material-icons icons jq_leftMenuCloseBtn">close</i>
        </div>
        
        <div class="body-container">

            <div class="body jq_leftMenuBody" data-clickedname='Kategorije'>
                <ul class="list">
                <?php foreach($catMobileMenu as $key=>$cval){ ?>
                    <?php if(count($cval["catchilds"])>0) { ?>
                        <li class="items">
                            <img src="fajlovi/ikone_kategorije/682.png" alt="mmmobil icons" class="img-responsive cat-icons-slide">
                            <a href="<?php echo rawurlencode($catval['catname']); ?>" class="links"><?php echo $cval['catname']; ?></a>
                             <i class="material-icons icons jq_forwardLeftMenuBtn">keyboard_arrow_right</i>
                        </li>
                    <?php } else { ?>
                        <li class="items">
                            <img src="fajlovi/ikone_kategorije/682.png" alt="mmmobil icons" class="img-responsive cat-icons-shop">
                            <a href="<?php echo rawurlencode($catval['catname']); ?>" class="links"><?php echo $cval['catname']; ?></a>
                        </li>
                    <?php } ?>
                <?php } ?>
                    
                   
                   <!--  <li class="items">
                        <a href="" class="links">Rančevi i školske torbe</a>
                        <i class="material-icons icons jq_forwardLeftMenuBtn">keyboard_arrow_right</i>
                    </li> -->
                </ul>
            </div>

        </div>

    </div>