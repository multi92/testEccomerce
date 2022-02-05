<div class="col-sm-4 langGroupCont langGroupContTemplate hide" defaultlang='' langid=''>
    <h3 class="box-title langname"></h3>
    
    <div class="form-group">
        <label>Broj javne nabavke</label>
        <input type="text" class="form-control numberJavne" placeholder="Broj javne nabavke">
    </div>
    <div class="form-group">
        <label>Predmet javne nabavke</label>
        <input type="text" class="form-control predmetJavne" placeholder="Predmet javne nabavke">
    </div>
    <div class="form-group">
        <label>Vrsta javne nabavke</label>
        <input type="text" class="form-control vrstaJavne" placeholder="Vrsta javne nabavke">
    </div>
    
    <hr />
   
    <h3>Dodaj dokument:</h3>
    
    <div class="form-group">
        <label>Putanja do dokumenta:</label>
        <input type="text" class="form-control urlJavne" placeholder="Putanja do dokumenta">
    </div>
    <div class="form-group">
        <label>Pozicija dokumenta:</label>
        <select class="form-control positionJavneSelect">
            <option value="1">Poziv</option>
            <option value="2">Konkursna</option>
            <option value="3">Pitanja</option>
            <option value="4">Obavestenje</option>
            <option value="5">Odluke</option>
        </select>
    </div>
    <button class="btn btn-primary form-control addJavneDocument" id="addJavneItem">Dodaj</button>
    
    <hr />
    
    <h3>Poziv</h3>
    
    <table class="table table-bordered table-responsive table-condensed position_1">
        <thead>
            <tr>
                <th>Naziv dokementa</th>
                <th>Status</th>
                <th>Datum dodavanja</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
         </tbody>
    </table>
    
    <h3>Konkursna</h3>
    
    <table class="table table-bordered table-responsive table-condensed position_2">
        <thead>
            <tr>
                <th>Naziv dokementa</th>
                <th>Status</th>
                <th>Datum dodavanja</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
         </tbody>
    </table>
    
    <h3>Pitanja</h3>
    
    <table class="table table-bordered table-responsive table-condensed position_3">
        <thead>
            <tr>
                <th>Naziv dokementa</th>
                <th>Status</th>
                <th>Datum dodavanja</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
         </tbody>
    </table>
    
    <h3>Obavestenje</h3>
    
    <table class="table table-bordered table-responsive table-condensed position_4">
        <thead>
            <tr>
                <th>Naziv dokementa</th>
                <th>Status</th>
                <th>Datum dodavanja</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
         </tbody>
    </table>
    
    <h3>Odluke</h3>
    
    <table class="table table-bordered table-responsive table-condensed position_5">
        <thead>
            <tr>
                <th>Naziv dokementa</th>
                <th>Status</th>
                <th>Datum dodavanja</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
         </tbody>
    </table>
    
</div>

<div class="col-sm-4 langGroupCont langGroupContAddTemplate hide" defaultlang='' langid=''>
    <h3 class="box-title langname"></h3>
    
    <div class="form-group">
        <label>Broj javne nabavke</label>
        <input type="text" class="form-control numberJavne" placeholder="Broj javne nabavke">
    </div>
    <div class="form-group">
        <label>Predmet javne nabavke</label>
        <input type="text" class="form-control predmetJavne" placeholder="Predmet javne nabavke">
    </div>
    <div class="form-group">
        <label>Vrsta javne nabavke</label>
        <input type="text" class="form-control vrstaJavne" placeholder="Vrsta javne nabavke">
    </div>
    
</div>

<tr javneitemid="" fullurl="" class="hide javneItemHolderTemplate">
    <td class="docname"></td>
    <td>
        <select class="form-control selectJavneItemStatus">
            <option value="1">Novi</option>
            <option value="0">Stari</option>
        </select>
    </td>                                           
    <td class="adddatecolum"></td>
    <td><button class="btn btn-danger deleteJavneItem">obrisi</button></td>
</tr>