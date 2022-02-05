<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Proizvodi
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
        <li class="active">poruke</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    	<div class="row">
            <div class="col-md-3">
              <!-- /. box -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Tip poruka</h3>
                  <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="changetype" msgtype=""><a ><i class="fa fa-circle-o text-green"></i> Sve</a></li>
                    <li class="changetype" msgtype="Predsednik opstine"><a ><i class="fa fa-circle-o text-red"></i> Predsednik opstine</a></li>
                    <li class="changetype" msgtype="Zamenik predsednika"><a><i class="fa fa-circle-o text-yellow"></i> Zamenik predsednika</a></li>
                    <li class="changetype" msgtype="Sekretar"><a ><i class="fa fa-circle-o text-light-blue"></i> Sekretar</a></li>
                    <li class="changetype" msgtype="Predsednik skupstine"><a ><i class="fa fa-circle-o text-red"></i> Predsednik skupstine</a></li>
                    <li class="changetype" msgtype="Vece"><a ><i class="fa fa-circle-o text-red"></i> Ve&#263;e</a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
            </div><!-- /.col -->
            <div class="col-md-9">
            	               
                
              <div class="box box-primary listAllMessagesCont" messagetype="">
                <div class="box-header with-border">
                  <h3 class="box-title">Inbox</h3>
                  <div class="box-tools pull-right">
                  		<input type="text" class="form-control emailSearchInput" placeholder="Pretraga"  />
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                      <div class="btn-group navButtonCont">
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                  <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped table-responsive">
                    
                    	<!-- message template row -->
                    	<tr messageid="" class="messageTemplate hide messageListItem">
                        	<td class="mailbox-color"></td>
                        	<td class="mailbox-name"></td>
                        	<td class="mailbox-subject"></td>
                        	<td class="mailbox-type"></td>
                       		<td class="mailbox-email"></td>
                        	<td class="mailbox-date"></td>
                        </tr>
                        
                      <tbody class="mailbox-messages-cont">
                        
                      </tbody>
                    </table><!-- /.table -->
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                      <div class="btn-group navButtonCont">
                        
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                </div>
              </div>
              
              
              <div class="box box-primary showMessageCont hide">
                <div class="box-header with-border">
                </div><!-- /.box-header -->
                
                <!-- template -->
                <div class="box-body no-padding showMessageItemTemplate hide">
                  <div class="mailbox-read-info">
                    <h3 class="showMessageTitle"></h3>
                    <h5 class="showMessageFrom"><span class="mailbox-read-time pull-right">15 Feb. 2015 11:03 PM</span></h5>
                  </div><!-- /.mailbox-read-info -->
                  <div class="mailbox-read-message"></div>
                  <hr  />
                </div>
                
                <div class="showMessageItemCont" firstMessageId="">
                
                </div>

				<!--
				<div class="box-body">
                     <div class="form-group">
                        <input class="form-control messageReplayInput" placeholder="naslov">
                      </div>
                      <div class="form-group">
                        <textarea rows="10" class="form-control messageTextareaInput" placeholder="poruka" ></textarea>
                      </div>
                      <div class="form-group">
                        <select class="form-control messageOdgovoriSelect" >
                        	<option value=""></option>
                            <?php
								$query = "SELECT * FROM odgovori";
								$re = mysqli_query($conn, $query);
								while($row = mysqli_fetch_assoc($re))
								{
									echo "<option value='".$row['id']."'>".$row['value']."</option>";
								}
							?>
                        </select>
                      </div>
                  </div>
				-->
	
                <div class="box-footer">
                  <div class="pull-right">
                    <button type="button" class="btn btn-warning messageUnreadButton">Oznaci kao neprocitano</button>
                  </div>
                 <!--
                  <div class="pull-right">
                    <button type="submit" class="btn btn-primary messageReplayButton"><i class="fa fa-envelope-o"></i>Odgovori</button>
                  </div>
                  -->
                </div><!-- /.box-footer -->
              </div>
            </div><!-- /.col -->
          </div>
          
       
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="printmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Stampa</h4>
      </div>
      <div class="modal-body">
        <!-- bodt start -->
        
        <div class="row headerrow">
        	<div class="col-sm-1"></div>
            <div class="col-sm-4">Sifra</div>
            <div class="col-sm-4">Naziv</div>
            <div class="col-sm-3">Cena</div>
        </div>
        
        <div class="row printItemTemplate">
        	<div class="col-sm-1"><input type="checkbox" checked="checked" /></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-3"><input type="text" class="form-control printCenaInput"  /></div>
        </div>
        
        
        <div class="printItemCont">
        
        </div>
        
        <div class="form-group">
        	<label>Komentar:</label>
        	<textarea class="form-control printComment"></textarea> 
        </div>
        
        <!-- bodt end -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Preuzmi</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->