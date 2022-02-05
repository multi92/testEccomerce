<div class="col-sm-6">
									<?php if($posrow['position'] == 'slider'){ ?>
										
										<label class="_margineTop20">Slajder preview</label>
										<!-- slider start -->
										<div id="bootstrap-touch-slider" class="carousel bs-slider fade  control-round indicators-line" data-ride="carousel"  data-interval="5000">
											<!-- Indicators -->
											<ol class="carousel-indicators">
												
												<?php 
												$q = "SELECT * FROM galleryitem WHERE galleryid = ".$command[2]." ORDER BY sort ASC";
												$res = mysqli_query($conn, $q);
												$i=0;
												while($row = mysqli_fetch_assoc($res)){ ?>
													<li data-target="#bootstrap-touch-slider" data-slide-to="<?php echo $i;?>" <?php if($i==0){echo 'class="active"';}?>></li>
													<?php $i++; } ?>
												</ol>
												<!-- Wrapper For Slides -->
												<div class="carousel-inner" role="listbox">
													<?php 
													$q = "SELECT * FROM galleryitem WHERE galleryid = ".$command[2]." ORDER BY sort ASC";
													$res = mysqli_query($conn, $q);
													$i=0;
													while($row = mysqli_fetch_assoc($res)){ ?>
														<div class="item <?php if($i==0){echo 'active';}?>">
															<!-- Slide Background -->
															<img src="../<?php echo $row['item'];?>" alt="Bootstrap Touch Slider" class="slide-image" />
															<div class="bs-slider-overlay"></div>
															<?php if($row['show_info']=='y'){?>

																<?php 
																$info_possition="";
																switch ($row['info_position']) {
																	case "l":
																	$info_possition="slide_style_left";
																	break;
																	case "c":
																	$info_possition="slide_style_center";
																	break;
																	case "r":
																	$info_possition="slide_style_right";
																	break;
																	default:
																	$info_possition="slide_style_center";
																}


																?>

																<div class="container">
																	<div class="row">
																		<!-- Slide Text Layer -->
																		<div class="slide-text <?php echo $info_possition;?>">
																		<?php if($row['title']!='' && strlen($row['title'])>0){ ?>
																			<h1 data-animation="animated zoomInRight"><?php echo $row['title'];?></h1>
																		<?php } ?>
																		<?php if($row['text']!='' && strlen($row['text'])>0){ ?>
																			<p data-animation="animated fadeInLeft"><?php echo $row['text'];?></p>
																		<?php } ?>
																		<?php if($row['link']!='' && strlen($row['link'])>0){ ?>
																			<a href="<?php echo $row['link'];?>" target="_blank" class="btn btn-default" data-animation="animated fadeInLeft">Više informacija</a>
																		<?php } ?>	
																		</div>
																	</div>
																</div>
															<?php }?>
														</div>





														<?php $i++; } ?>
														<!-- Third Slide -->

														<!-- End of Slide -->
														<!-- Second Slide -->
														<!-- <div class="item">
															
															<img src="images/slide2.jpeg" alt="Bootstrap Touch Slider" class="slide-image" />
															<div class="bs-slider-overlay"></div>
															
															<div class="slide-text slide_style_center">
																<h1 data-animation="animated flipInX">Bootstrap touch slider</h1>
																<p data-animation="animated lightSpeedIn">Make Bootstrap Better together.</p>
																<a href="#" target="_blank" class="btn btn-default" data-animation="animated fadeInUp">select one</a>
																
															</div>
														</div> -->
														<!-- End of Slide -->
														<!-- Third Slide -->
														<!-- <div class="item">
															
															<img src="images/slide3.jpeg" alt="Bootstrap Touch Slider" class="slide-image" />
															<div class="bs-slider-overlay"></div>
															
															<div class="slide-text slide_style_right">
																<h1 data-animation="animated zoomInLeft">Beautiful Animations</h1>
																<p data-animation="animated fadeInRight">Lots of css3 Animations to make slide beautiful .</p>
																<a href="#" target="_blank" class="btn btn-default" data-animation="animated fadeInLeft">select one</a>
																
															</div>
														</div> -->
														<!-- End of Slide -->
													</div>
													<!-- End of Wrapper For Slides -->
													<!-- Left Control -->
													<a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
														<span class="fa fa-angle-left" aria-hidden="true"></span>
														<span class="sr-only">Previous</span>
													</a>
													<!-- Right Control -->
													<a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
														<span class="fa fa-angle-right" aria-hidden="true"></span>
														<span class="sr-only">Next</span>
													</a>
												</div>

											<?php }?>
										</div>