<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
  					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
  							<span itemprop="name"><?php echo $language["global"][3]; ?></span>

  						</a>
						
  					</li>
  					
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $pagename;?></span>
  					</li>
				</ol>

</div>
<section class="content min-height">
    <div class="container">
       <div class="row db-page-cont">
        <div class="col-md-12">
          <h4 class="after marginBottom30"><?php echo $pagename;?></h4>
       </div>

         
        <div class="col-md-12 table-responsive">
               <?php
               if(isset($row['valuetr']))
               		echo $row['valuetr'];
               	else
               		echo $row['value'];
                ?>
        </div>
         <div class="clear"></div>
        <div class="col-md-12 ">
          
          <div class="row _unmargin">
           <?php foreach ($galleryitems[1] as $gallery) { 
             include($system_conf["theme_path"][1]."views/includes/gallerybox/galleryImageBox.php");
            } 
          ?>
          </div>
          
        </div>
        
               
				
       </div>
    </div>
</section>