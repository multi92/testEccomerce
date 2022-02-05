
<!-- Content Wrapper. Contains page content -->
   
<div class="content-wrapper">
		
        <!-- Content Header (Page header) -->
        <section class="content-header -breadcrumbColor">
          <h1>
            <i class="fa fa-map-marker"></i> Prijava problema 
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li class="active"><i class="fa fa-map-marker"></i> Poruke</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
         <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listMessageButton">Lista poruka</button>
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
          <div class="row list_email">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Inbox</h3>
                  <div class="box-tools pull-right">
                    
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  
                  <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                      <tbody>
                      	<?php
							
							$query = "SELECT * FROM komunalac ORDER BY added DESC";
							$re = mysqli_query($conn, $query);
							
							while($row = mysqli_fetch_assoc($re))
							{
								$date = explode(" ",$row['added']);
								$da = explode("-",$date[0]);
								echo '<tr>
								  <td><input type="checkbox" /></td>
								  <td class="mailbox-star"></td>
								  <td class="mailbox-name open_email" emailid="'.$row['id'].'"><a>'.$row['name'].'</a></td>
								  <td class="mailbox-subject open_email" emailid="'.$row['id'].'">'.$row['email'].'</td>
								  <td class="mailbox-attachment">'.$row['phone'].'</td>
								  <td class="mailbox-date">'.$da[2].'-'.$da[1].'-'.$da[0].' '.$date[1].'</td>
								</tr>';	
							}	
						?>
                      </tbody>
                    </table><!-- /.table -->
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                  
                </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          
          <!-- show message -->
          <div class="row show_email">
           
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  
                  <div class="box-tools pull-right">
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-read-info">
                    <h3 class="message_title"></h3>
                    <h5 class="message_email"></h5>
                    <h5 class="message_recive"></h5>
					<h5 class="message_object"></h5>
                  </div><!-- /.mailbox-read-info -->
                  <!-- /.mailbox-controls -->
                  <div class="mailbox-read-message message_message">
                    
                  </div><!-- /.mailbox-read-message -->
				  <hr />
				  <div class="mailbox-read-message ">
				  	<h4 class="">Fajlovi u prilogu</h4>
					<ul class="message_files">
						
					</ul>
                  	<!--<a class="maplink" target="_blank">Pogledaj na mapi lokaciju</a>-->
                  </div>
                </div><!-- /.box-body -->
                <!-- /.box-footer -->
                <!-- /.box-footer -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div>
          <!-- show message end -->
          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

