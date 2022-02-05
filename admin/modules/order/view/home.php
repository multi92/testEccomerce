<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Porudžbine
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active">Porudžbine</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista porudžbina</button>
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
      
        
        <div class="row listCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista svih porudžbina u bazi</h3>
                </div><!-- /.box-header -->
      <div class="box-body table-responsive">
					<div class="row">
						<div class="col-sm-2">
							<div class="checkbox">
								<label>Status</label>
								<select class="jq_statusSelect">
									 <option value=""></option>
									 <option value="n">Nova</option>
									 <option value="o">U obradi</option>
									 <option value="f">Za slanje</option>
									 <option value="w">Za slanje na čekanju</option>
									 <option value="s">Poslata</option>
									 <option value="p">Naplaćena</option>
									 <option value="d">Odbijena</option>
									 <option value="u">Odbijena sa razlogom</option>
								 </select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>Način plaćanja</label>
								<select class="jq_paymentSelect">
									 <option value=""></option>
									 <option value="k">Kartica</option>
									 <option value="p">Pouzećem</option>
								 </select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>Tip dokumenta</label>
								<select class="jq_typeSelect">
									 <option value=""></option>
									 <option value="E">Rezervacija</option>
									 <option value="Q">Upit</option>
								 </select>
							</div>
						</div>
						
						<div class="col-sm-2">
							<div class="checkbox hide">
								<label>Zemlja</label>
								<select class="jq_countrySelect">
									 <option value=""></option>
									 <option value="9">Srbija</option>
									 <option value="90">Bosna i Hercegovina</option>
									 <option value="91">Crnagora</option>
								 </select>
							</div>
						</div>
						
						<div class="col-sm-6 hide">
							<p>TRENUTNO OČEKIVANI OTKUP PO SVIM POSLATIM A NEPLAĆENIM PORUDŽBINAMA JE : <span><b class="jq_totalSentValue"></b></span></p>
						</div>
					</div>
					
					
					<hr />
                      <table class="table table-responsive table-striped" id="listtable" >
                        <thead>
                            <tr>
                                <th >Redni Broj</th>
                                <th >Broj</th>
                                <th >Iznos</th>
                                <th >Datum</th>
                                <th >Datum slanja</th>
                                <th >Email</th>
                                <th >Ime i prezime</th>
                                <th >Plaćanje / status</th>
								<th >Status</th>
                                <th>Izmeni</th>
                                <th>Kod za dostavu</th>
                            </tr>
                       <thead>
                       <tbody>
                       
                       </tbody>
                    </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div>
          
      <!-- Your Page Content Here -->
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
