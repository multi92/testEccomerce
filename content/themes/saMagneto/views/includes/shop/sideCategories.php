<?php 

$expand="true";
$collapsecat="collapse in";
if($isLastCategory){
	$expand="false";
	$collapsecat="collapse";
}
?>
<?php $cms_hide_category_icon=''; if($user_conf["show_category_icon"][1]=='0'){ $cms_hide_category_icon='hide'; }?>
<div class="panel-group hide" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="<?php echo $expand;?>" aria-controls="collapse1">
                    <?php echo $language["side_categories"][1]; //Kategorije?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>
                </a>
            </h4>
        </div>
		
        <div id="collapse1" class="panel-collapse <?php echo $collapsecat;?>" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="side-kate-ul">
                
				<?php for($i = 0; $i < count($catdata); $i++){ ?>
					<?php if(isset($catdata[$i]['subcats']) && count($catdata[$i]['subcats'])>0){ ?>
						<li class="side-kate-li">
							<img src="<?php echo $catdata[$i]['icon'];?>" alt="sa icons" class="img-responsive cat-icons-shop <?php echo $cms_hide_category_icon;?>" style="width:20px;">
							<a href="<?php echo $catdata[$i]['urlname'];?>"><?php echo $catdata[$i]['name'];?></a> 
							<i class="fa fa-angle-right side-drop-triger" aria-hidden="true"></i>
						<div class="side-kate-drop">
                            <ul class="side-kate-drop-ul">
							<?php foreach($catdata[$i]['subcats'] as $key=>$val){ ?>
								<?php if(isset($val['catchilds']) && count($val['catchilds'])>0){ ?>

									<li class="side-kate-drop-li"><a href="<?php echo $catdata[$i]['urlname'].'/'.$val['urlname']; ?>"> <?php echo $val['name']; ?></a> <i class="fa fa-angle-right side-drop-triger2" aria-hidden="true"></i>
									<div class="side-kate-drop2">
                                        <ul class="side-kate-drop-ul">
										<?php foreach($val['catchilds'] as $k=>$v){ ?>
											<li class="side-kate-drop-li">
												<?php if(isset($v['catchilds']) && count($v['catchilds'])>0){ ?>
												<a href="<?php echo $catdata[$i]['urlname'].'/'.$val['urlname'].'/'.$v['urlname']; ?>"><?php echo $v['name']; ?></a>
												<i class="fa fa-angle-right side-drop-triger3" aria-hidden="true"></i>
												<div class="fourth-deep-shop">
													<ul class="list">
														<?php foreach($v['catchilds'] as $k=>$vv){ ?>
															<li class="items"><a href="<?php echo $catdata[$i]['urlname'].'/'.$val['urlname'].'/'.$v['urlname'].'/'.$vv['urlname']; ?>" class="links"><?php echo $vv['name']; ?></a></li>
														<?php } ?>
														
													</ul>
												</div>
											<?php } else {?>
												<a href="<?php echo $catdata[$i]['urlname'].'/'.$val['urlname'].'/'.$v['urlname']; ?>"><?php echo $v['name']; ?></a>
											<?php } ?>
											</li>
										<?php } ?>
										</ul>
                                    </div>
								<?php } else { ?>
									<li class="side-kate-drop-li"><a href="<?php echo $catdata[$i]['urlname'].'/'.$val['urlname']; ?>"> <?php echo $val['name']; ?></a></li>
								 <?php } ?>
							<?php } ?>
							</ul>
                        </div>
						</li>
					<?php } else { ?>
						<li class="side-kate-li"><img src="<?php echo $catdata[$i]['icon'];?>" alt="sa icons" class="img-responsive cat-icons-shop" style="width:20px;"><a href="<?php echo $catdata[$i]['urlname'];?>"> <?php echo $catdata[$i]['name'];?></a></li>
                    <?php } ?>
				<?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="navigation-holder left-fixed dsn_shop-categories-menu-holder">
                    <div class="navigation" id="main-drop">
                         <ul class="nav-ul">

                        <?php foreach($topmenudata as $key=>$val){ ?>
                        <?php $act = '';
                              if($command[0] == $val['baselink']) $act = 'active';
                        ?>
                     
                        <?php if($val['menutype']=='catfw'){ ?>
                            
                                <!-- classs:main-drop-triger -->
                            <li class="nav-li opened-drop pos hidden-sm hidden-xs shop-categories-expand dsn_shop-categories-expand">
                                <span class="flex-list-link">
                                <span class="material-icons icons">list</span>
                                <a style="cursor: auto;"><?php echo $language["side_categories"][1];?>
                                    <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> -->
                                </a>
                                </span>
                                <i class="fa fa-angle-down icons -arrow" aria-hidden="true"></i>
                                
                            </li>
                            
                            <?php } ?>
                        <?php } ?>
                        </ul>
                        <div class="main-drop hidden-sm hidden-xs shop-categories-drop">
                                    <ul class="main-drop-ul">
                                        <?php foreach($catcont as $key=>$cval){ ?>
                                            
                                        <?php if(count($cval["catchilds"])>0) { ?>
                                         <li class="main-drop-li">
                                            <div class="cate-icons-link-holder">
                                            <img src="<?php echo $cval['icon']; ?>" alt="sa icons" class="img-responsive cat-icons <?php echo $cms_hide_category_icon;?>">
                                            <a href="<?php echo rawurlencode($cval['catpathname']); ?>" class="main-drop-a"  ><?php echo $cval['catname']; ?>
                                            </div>
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                            </a>
                                            <div class="sec-drop">
                                                <div class=" _unmargin under-cate-row" >
                                                    
                                                <?php foreach($cval["catchilds"] as $kcc=>$ccval){ ?>
                                                    <div class=" col-seter under-cate-col">
                                                        <ul class="sec-drop-ul">
                                                    <?php if(count($ccval["catchilds"])>0) { ?>
                                                            <li class="sec-drop-li">
                                                                <a href="<?php echo rawurlencode($cval['catpathname']).'/'.rawurlencode($ccval['urlname']); ?>" class="soc-drop-a1">
                                                                    <div class="img-link-prod-cate-num">
                                                                    <img src="<?php echo GlobalHelper::getImage(rawurldecode($ccval['catimage']), 'small'); ?>" alt="softart icon" class="img-responsive ">
                                                                    <?php echo $ccval['name']; ?>
                                                                    </div>
                                                                    <!-- <span class="prod-cate-number">(12987)</span> -->
                                                                </a>
                                                                     
                                                                    <?php $dt=array();foreach($dt as $kccc=>$cccval) { ?>
                                                                       <!--  <?php //foreach($ccval["catchilds"] as $kccc=>$cccval) { ?> -->
                                                                        <div class="last-holder">
                                                                            <?php if(count($cccval["catchilds"])>0) { ?>
                                                                            <div class="last-link-icons">
                                                                                <a href="<?php echo rawurlencode($cval['catpathname']).'/'.rawurlencode($ccval['urlname'])."/".rawurlencode($cccval['urlname']); ?>" class="soc-drop-a2"  ><?php echo $cccval['name']; ?>
                                                                            
                                                                                </a>
                                                                                <div style="display: flex;align-items: center;justify-content: space-between;">
                                                                                <span class="prod-cate-number">(12987)</span>
                                                                                <i class="fa fa-angle-down dsn_mainCateMenuTriggerFourth" aria-hidden="true"></i>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="fourth-deep dsn_fourthDeepDrop ">
                                                                                <ul class="list">
                                                                                    <?php foreach($cccval["catchilds"] as $kcccc=>$ccccval) { ?>
                                                                                    <li class="items"><a href="<?php echo rawurlencode($cval['catpathname']).'/'.rawurlencode($ccval['urlname'])."/".rawurlencode($cccval['urlname'])."/".rawurlencode($ccccval['urlname']); ?>" class="links"><?php echo $ccccval['name']; ?></a></li>
                                                                                    
                                                                                    <?php }?>
                                                                                </ul>
                                                                            </div>
                                                                            <?php } else {?>
                                                                                <div class="last-link-icons">
                                                                                <a href="<?php echo rawurlencode($cval['catpathname']).'/'.rawurlencode($ccval['urlname'])."/".rawurlencode($cccval['urlname']); ?>" class="soc-drop-a2"  ><?php echo $cccval['name']; ?>
                                                                            
                                                                                </a>
                                                                                <div style="display: flex;align-items: center;justify-content: space-between;">
                                                                                <!-- <span class="prod-cate-number">(12987)</span> -->
                                                                                <i class="fa fa-angle-down vis-cate-prod" aria-hidden="true"></i>
                                                                                </div>
                                                                            </div>
                                                                            <?php }?>
                                                                        </div>
                                                                    <?php }?>
                                                                
                                                            </li>
                                                    
                                                    <?php } else {?>
                                                            <li class="sec-drop-li"  >
                                                                <a href="<?php echo rawurlencode($cval['catpathname']).'/'.rawurlencode($ccval['urlname']); ?>" class="soc-drop-a1"  >
                                                                    <div class="img-link-prod-cate-num">
                                                                    <img src="<?php echo GlobalHelper::getImage(rawurldecode($ccval['catimage']), 'small'); ?>" alt="softart icon" class="img-responsive">
                                                                    <?php echo $ccval['name']; ?>
                                                                    </div>
                                                               <!-- <span class="prod-cate-number">(12987)</span> -->
                                                               </a>
                                                            </li>
                                                    
                                                    <?php } ?>
                                                        </ul>
                                                    </div>
                                                <?php } ?>  
                                                </div>
                                            </div>
                                        </li>   
                                        <?php } else { ?>
                                            <li class="main-drop-li">
                                                <div class="cate-icons-link-holder">
                                                <img src="<?php echo $cval['icon']; ?>" alt="sa icons" class="img-responsive cat-icons <?php echo $cms_hide_category_icon;?>">
                                                <a href="<?php echo rawurlencode($cval['catpathname']); ?>" class="main-drop-a"  ><?php echo $cval['catname']; ?> </a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div> 
                    </div>         
                </div>