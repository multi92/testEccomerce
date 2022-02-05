<?php


class ShowCTRL
{

    private $viewmodel;

    public function __construct()
    {
        $this->viewmodel=array();
        $this->viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['menu_footer']=MenuRepository::Get(48);
        $this->viewmodel['menu_ustanove']=UstanovaRepository::getAll();
        $this->viewmodel['translations']=Helper::get_all_glob_translate(Session::GetVarVal('langid'));
        $this->viewmodel['meta']['title']='';
        $this->viewmodel['meta']['desc']='Template 01 desc ...';
        $this->viewmodel['meta']['keywords']='keywords, sporeti';
        $this->viewmodel['meta']['img']='localhost/www/template01/fajlovi/logo.jpg';

        //identifikatori galerija u bazi koje su povezane sa konkretnom stavkom menija
        $menu_galleries_id=array(6,7,8,9,10,11,12);
        for($i=0 ; $i<7; $i++)
        {
            $this->viewmodel['menu-gallery'][]=GalleryRepository::GetGallery($menu_galleries_id[$i],false,false,true);
        }

        $this->viewmodel['activeMenu'] = Helper::activeMenu();
        $cats = Helper::getAllMainCats();
        $this->viewmodel['mainCats'] = $cats;


        /*For menu all prod*/
        $prods = ProdHelper::get_all_cat_pro_h(81, 1, 999999999);
        $numOfprod = $prods['num_of_prod'];
        $min_max_price=$prods['min_max_price'];
        $prods = $prods['prod'];
        $this->viewmodel['menuprods'] = $prods;



    }

    public function RenderHome(Router $r)
    {

//        $this->viewmodel['top_news']=NewsRepository::getAllNews(1,6,true);

        $this->viewmodel['gallery']=GalleryRepository::GetGallery('home');
        $this->viewmodel['photo-gallery']=GalleryRepository::GetFotoGalleryHome();
        $this->viewmodel['video-gallery']=GalleryRepository::GetVideoGalleryHome();
        $this->viewmodel['banners']=BannerRepository::getAll();

        $this->viewmodel['breadcrumb']='';

        return $this->viewmodel;
    }

    public function RenderMirisi(Router $r)
    {
        $this->viewmodel['breadcrumb']='';

        return $this->viewmodel;
    }
    public function RenderNovo(Router $r)

    {
        global $news_per_page;
//        $viewmodel=array();


//        $viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['news']=NewsRepository::getAllNews($r->p, $news_per_page);
        foreach($this->viewmodel['news'] as $news){
            if(strlen($news->body) > 200){
                $news->body = substr($news->body, 0, 200) . '...';
            }
        }


        $param_url = '';
        $all_params = explode('&', $_SERVER['QUERY_STRING']);
        $numOfPages = ceil(NewsRepository::newsCount()/$news_per_page);

        for($i=0;$i<count($all_params);$i++) {
            $a_params=explode("=", $all_params[$i]);
            if(count($a_params)!= 2){
                continue;
            }
            $key = $a_params[0];
            $value=urldecode($a_params[1]);

            if($key === 'p' && is_numeric($value) && $value>0 && $value <=$numOfPages){
                $pagination_page = $value;
            }
            else{
                if ($key == 'p' && $value == 0){
                    $pagination_page = '0';
                }
                else{
                    $param_url.= "$value/";
                }
            }
        }




        $this->viewmodel['numOfPages'] = $numOfPages;
        $this->viewmodel['param_url'] = $param_url;
        $this->viewmodel['r'] = $r;

        $this->viewmodel['breadcrumb']=$r->page.' / ';
        $this->viewmodel['meta']['title']='Vesti';


        return $this->viewmodel;
    }
    public function RenderProizvodi(Router $r)
    {
        global $shop_product_per_page;
        $cat = new Category($r->id);
        /*parent cats za breadcrumb*/
        $parentCats = ProdHelper::getParentCat($cat->parentid, array());
        $parentCats = array_reverse($parentCats);
        $this->viewmodel['parentCats'] = $parentCats;
        $this->viewmodel['thisCat'] = $cat;

        $searched = Helper::ParseUrl();

        $aray = array_keys($searched);
        $artVALUES = array();
        foreach ($aray as $attrid) {
            if ($attrid != 'page' && $attrid != 'id' && $attrid != 'p'&& $attrid != 'amount1'&& $attrid != 'amount2') {
                $artVALUES[] = $searched[$attrid];

            }elseif($attrid == 'amount1')
            {
                $artVALUES['min'] = $searched[$attrid];
            }elseif($attrid == 'amount2'){
                $artVALUES['max'] = $searched[$attrid];
            }
        }
//        var_dump($artVALUES);

        if (!empty($artVALUES)) {
            // var_dump($artVALUES);
            $prods = ProdHelper::get_all_cat_pro_h($cat->categoryprid, $r->p, $shop_product_per_page, false, false, false, $artVALUES);
            $numOfprod = $prods['num_of_prod'];
            $min_max_price=$prods['min_max_price'];
            $prods = $prods['prod'];
        } else {
            $prods = ProdHelper::get_all_cat_pro_h($cat->categoryprid, $r->p, $shop_product_per_page);
            $numOfprod = $prods['num_of_prod'];
            $min_max_price=$prods['min_max_price'];
            $prods = $prods['prod'];
//            var_dump($prods);


        }
//        var_dump($prods);
        $this->viewmodel['prods'] = $prods;

        $cats = Helper::getAllMainCats();
        $this->viewmodel['mainCats'] = $cats;
        if(Session::GetVarVal('viewtype')){
            $this->viewmodel['viewtype'] = Session::GetVarVal('viewtype');
        }
        else{
            $this->viewmodel['viewtype'] = Session::GetVarVal('viewtype');
        }



/*
 * ZA PAGINACIJU
 * ***************/
        $numOfPages = ceil($numOfprod / $shop_product_per_page);
        $param_url = '';
        $all_params = explode('&', $_SERVER['QUERY_STRING']);
        for ($i = 0; $i < count($all_params); $i++) {
            $a_params = explode("=", $all_params[$i]);
            if (count($a_params) != 2) {
                continue;
            }
            $key = $a_params[0];
            $value = urldecode($a_params[1]);

            if ($key === 'p' && is_numeric($value) && $value > 0 && $value <= $numOfPages) {
                $pagination_page = $value;
            } else {
                if ($key == 'p' && $value == 0) {
                    $pagination_page = '0';
                } else {
                    $param_url .= "$value/";
                }
            }
        }
        $this->viewmodel['numOfPages'] = $numOfPages;
        $this->viewmodel['param_url'] = $param_url;
        $this->viewmodel['r'] = $r;





        $this->viewmodel['breadcrumb']='';

        return $this->viewmodel;
    }

    public function RenderKategorije(Router $r)
    {

        $cats_name = Helper::get_cat_tr_name(0);

        $this->viewmodel['chield_cats'] = CategoryRepository::getChieldCats($r->id);
        $cat = new Category($r->id);
        /*parent cats za breadcrumb*/
        $parentCats = ProdHelper::getParentCat($cat->parentid, array());
        $parentCats = array_reverse($parentCats);
        $this->viewmodel['parentCats'] = $parentCats;
        $this->viewmodel['thisCat'] = $cat;
        return $this->viewmodel;
    }

    public function RenderPretraga(Router $r)
    {
        $searched = Helper::ParseUrl();//vadi zahteve iz urla

        $aray = array_keys($searched);//uzima imena promenjivih iz zahteva
        $artVALUES = array();
        //smesta vrenosti u niz parametara po kojima se vrsi pretraga
        foreach ($aray as $attrid) {
            if ($attrid != 'page' && $attrid != 'id' && $attrid != 'p') {
                if($attrid == 'search'){
                    $artVALUES[$attrid] = $searched[$attrid];
                }
            }
        }
        if(isset($artVALUES['search'])){
            $this->viewmodel['searchworld'] = $artVALUES['search'];
            $this->viewmodel['prods'] = array();
            global $shop_product_per_page;
            $prods = ProdHelper::get_all_cat_pro_h( 0, $r->p, $shop_product_per_page, false, false, false, false, false, false, false, false, false, $artVALUES );
            $numOfprod = $prods['num_of_prod'];
            $prods = $prods['prod'];
            $this->viewmodel['prods'] = $prods;

            /*
             * ZA PAGINACIJU
             * ***************/
            $numOfPages = ceil($numOfprod / $shop_product_per_page);
            $param_url = '';
            $all_params = explode('&', $_SERVER['QUERY_STRING']);
            for ($i = 0; $i < count($all_params); $i++) {
                $a_params = explode("=", $all_params[$i]);
                if (count($a_params) != 2) {
                    continue;
                }
                $key = $a_params[0];
                $value = urldecode($a_params[1]);

                if ($key === 'p' && is_numeric($value) && $value > 0 && $value <= $numOfPages) {
                    $pagination_page = $value;
                } else {
                    if ($key == 'p' && $value == 0) {
                        $pagination_page = '0';
                    } else {
                        if($key == 'search'){
                            $vals = explode(' ', $value);
                            foreach($vals as $val){
                                $param_url.= "$key=$val&";
                            }
                        }
                        else{
                            //                        $param_url .= "$value/";
                            $param_url.= "$key=$value&";
                        }

                    }
                }
            }
            $this->viewmodel['numOfPages'] = $numOfPages;
            $this->viewmodel['param_url'] = $param_url;
            $this->viewmodel['r'] = $r;
        }
        return $this->viewmodel;
    }

    public function RenderOnama(Router $r)
    {
        $this->viewmodel['onama'] = '';
        return $this->viewmodel;
    }
    public function RenderQuality(Router $r)
    {
        $this->viewmodel['quality'] = '';
        return $this->viewmodel;
    }
    public function RenderPersonalizedPerfumes(Router $r)
    {
        $this->viewmodel['personalizedperfumes'] = '';
        return $this->viewmodel;
    }
    public function RenderAvailable_shapes(Router $r)
    {
        $this->viewmodel['available_shapes'] = '';
        $this->viewmodel['displays'] = DisplayRepository::getDisplays('shap');
        return $this->viewmodel;
    }
    public function RenderCellulose_samples(Router $r)
    {
        $this->viewmodel['cellulose_samples'] = '';
        $this->viewmodel['displays'] = DisplayRepository::getDisplays('cel');
        return $this->viewmodel;
    }
    public function RenderBottle_shapes(Router $r)
    {
        $this->viewmodel['bottle_shapes'] = '';
        return $this->viewmodel;
    }
    public function RenderDisplays(Router $r)
    {
        $this->viewmodel['displays'] = DisplayRepository::getDisplays('dis');
        return $this->viewmodel;
    }
    public function RenderMojNalog(Router $r)
    {
        $allOrders = OrderingHelper::GetUsersOrders(Session::GetVarVal('id'));

        $user = UserHelper::getUser(Session::GetVarVal('id'));
//var_dump($user);
        $this->viewmodel['allOrders'] = $allOrders;
        $this->viewmodel['user'] = $user;
        return $this->viewmodel;
    }

    public function RenderRegisterconf(Router $r)
    {

        Helper::MailConfirm($r->id);
        return $this->viewmodel;
    }

    public function RenderProizvod(Router $r)
    {
        $this->viewmodel['breadcrumb']='';
        $this->viewmodel['proizvod'] = ProductRepository::getByID($r->id);
        $parentCats = ProdHelper::getParentCat($this->viewmodel['proizvod']->categoryId, array());
        $this->viewmodel['parentCats'] = array_reverse($parentCats);
        $pic_array = $this->viewmodel['proizvod']->GetPictures();
        $pic_array_with_attrvalname = $this->viewmodel['proizvod']->GetPicturesWithAttributesName();
        $attributes = $this->viewmodel['proizvod']->GetAttributes();
        $prices = $this->viewmodel['proizvod']->GetRealPrice();
        $this->viewmodel['pic_array'] = $pic_array;
        $this->viewmodel['pic_array_with_attrvalname'] = $pic_array_with_attrvalname;
        $this->viewmodel['attributes'] = $attributes;
        $this->viewmodel['prices'] = $prices;

        return $this->viewmodel;
    }

    public function RenderUser(Router $r)
    {
        $viewmodel=array();
        return $viewmodel;
    }

    public function getAllNews(Router $r)
    {
        global $news_per_page;
//        $viewmodel=array();


//        $viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['news']=NewsRepository::getAllNews($r->p, $news_per_page);
        foreach($this->viewmodel['news'] as $news){
            if(strlen($news->body) > 200){
                $news->body = substr($news->body, 0, 200) . '...';
            }
        }


        $param_url = '';
        $all_params = explode('&', $_SERVER['QUERY_STRING']);
        $numOfPages = ceil(NewsRepository::newsCount()/$news_per_page);

        for($i=0;$i<count($all_params);$i++) {
            $a_params=explode("=", $all_params[$i]);
            if(count($a_params)!= 2){
                continue;
            }
            $key = $a_params[0];
            $value=urldecode($a_params[1]);

            if($key === 'p' && is_numeric($value) && $value>0 && $value <=$numOfPages){
                $pagination_page = $value;
            }
            else{
                if ($key == 'p' && $value == 0){
                    $pagination_page = '0';
                }
                else{
                    $param_url.= "$value/";
                }
            }
        }




        $this->viewmodel['numOfPages'] = $numOfPages;
        $this->viewmodel['param_url'] = $param_url;
        $this->viewmodel['r'] = $r;

        $this->viewmodel['breadcrumb']=$r->page.' / ';
        $this->viewmodel['meta']['title']='Vesti';


        return $this->viewmodel;
    }

    public function getNews(Router $r)
    {
//        $viewmodel=array();
//        $viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['news']=NewsRepository::getNews($r->id);

        $this->viewmodel['breadcrumb']='vesti / '.$this->viewmodel['news']['main']->title;

        $this->viewmodel['meta']['title']='vest - '.$this->viewmodel['news']['main']->title;


        return $this->viewmodel;
    }

    public function GetSimplePage(Router $r){

        //$viewmodel['menu']=MenuRepository::Get(1);

        $this->viewmodel['page'] = SimplePageRepository::GetPage($r->id);
        $this->viewmodel['breadcrumb']=''.$this->viewmodel['page']->name;
        $this->viewmodel['meta']['title']=$this->viewmodel['page']->name;

        return $this->viewmodel;
    }

    public function RenderJavne(Router $r){
        global $javne_nabavke_per_page;



        $javneNabavke = JavneNabavkeRepository::getData($r->p, $javne_nabavke_per_page );
        $numOfPages = ceil(JavneNabavkeRepository::getCount()/$javne_nabavke_per_page);
        $param_url = '';
        $all_params = explode('&', $_SERVER['QUERY_STRING']);

        for($i=0;$i<count($all_params);$i++) {
            $a_params=explode("=", $all_params[$i]);
            if(count($a_params)!= 2){
                continue;
            }
            $key = $a_params[0];
            $value=urldecode($a_params[1]);

            if($key === 'p' && is_numeric($value) && $value>0 && $value <=$numOfPages){
                $pagination_page = $value;
            }
            else{
                if ($key == 'p' && $value == 0){
                    $pagination_page = '0';
                }
                else{
                    $param_url.= "$value/";
                }
            }
        }


        //$viewmodel = array();

        //$viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['javneNabavke'] = $javneNabavke;
        $this->viewmodel['numOfPages'] = $numOfPages;
        $this->viewmodel['param_url'] = $param_url;
        $this->viewmodel['r'] = $r;
        //$viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['breadcrumb']='javne nabavke';

        $this->viewmodel['meta']['title']='javne nabavke';



        return $this->viewmodel;

    }

    public function RenderDokumenta(Router $r){
        global $dokumenta_per_page;
        $viewmodel['menu']=MenuRepository::Get(1);

        $dokumenta = DokumentaRepository::getData($r->p, $dokumenta_per_page );
        $numOfPages = ceil(DokumentaRepository::getCount()/$dokumenta_per_page);
        $param_url = '';
        $all_params = explode('&', $_SERVER['QUERY_STRING']);
        for($i=0;$i<count($all_params);$i++) {
            $a_params=explode("=", $all_params[$i]);
            if(count($a_params)!= 2){
                continue;
            }
            $key = $a_params[0];
            $value=urldecode($a_params[1]);

            if($key === 'p' && is_numeric($value) && $value>0 && $value <=$numOfPages){
                $pagination_page = $value;
            }
            else{
                if ($key == 'p' && $value == 0){
                    $pagination_page = '0';
                }
                else{
                    $param_url.= "$value/";
                }
            }
        }


        //$viewmodel = array();

        $this->viewmodel['dokumenta'] = $dokumenta;
        $this->viewmodel['numOfPages'] = $numOfPages;
        $this->viewmodel['param_url'] = $param_url;
        $this->viewmodel['r'] = $r;
        //$viewmodel['menu']=MenuRepository::Get(1);

        $this->viewmodel['breadcrumb']='dokumenta';
        $this->viewmodel['meta']['title']='dokumenta';

        return $this->viewmodel;

    }

    public function RenderUstanova(Router $r){
       // $viewmodel = array();
        $this->viewmodel['ustanova'] = UstanovaRepository::get($r->id);
        $this->viewmodel['ustanove'] = UstanovaRepository::getAll();
        //$this->viewmodel['menu']=MenuRepository::Get(1);
        $this->viewmodel['breadcrumb']='ustanove / '.$this->viewmodel['ustanova']->title;
        $this->viewmodel['meta']['title']='Ustanova - '.$this->viewmodel['ustanova']->title;
        return $this->viewmodel;
    }

    public function RenderPhotoGallery(Router $r)
    {
        //$viewmodel=array();



        //$viewmodel['menu']=MenuRepository::Get(1);

        $this->viewmodel['gallery']=GalleryRepository::GetGallery($r->id, false, false, true);
        $this->viewmodel['breadcrumb']='foto galerija';
        $this->viewmodel['meta']['title']='Foto galerija';
        return $this->viewmodel;

    }
    public function RenderPhotoGallerys(Router $r)
    {
        //$viewmodel=array();



        //$viewmodel['menu']=MenuRepository::Get(1);

        $this->viewmodel['gallerys']=GalleryRepository::GetGallerys('1');
        $this->viewmodel['breadcrumb']='foto galerije';
        $this->viewmodel['meta']['title']='Foto galerije';
        return $this->viewmodel;

    }

    public function RenderVideoGallery(Router $r)
    {
//        $viewmodel=array();
//
//        $viewmodel['menu']=MenuRepository::Get(1);

        $this->viewmodel['gallery']=GalleryRepository::GetGallery($r->id, false, false, true);
        $this->viewmodel['breadcrumb']='video galerija';
        $this->viewmodel['meta']['title']='Video galerija';
        return $this->viewmodel;

    }

    public function RenderVideoGallerys(Router $r)
    {
//        $viewmodel=array();
//
//        $viewmodel['menu']=MenuRepository::Get(1);

        $this->viewmodel['gallerys']=GalleryRepository::GetGallerys('2');
        $this->viewmodel['breadcrumb']='video galerija';
        $this->viewmodel['meta']['title']='Video galerija';
        return $this->viewmodel;

    }

    public function getAllNotices(Router $r)
    {
        global $news_per_page;


        $this->viewmodel['notices'] = NoticeRepository::getAllNotices($r->p, $news_per_page);

        foreach ($this->viewmodel['notices'] as $notice) {
            if (strlen($notice->body) > 200) {
                $notice->body = substr($notice->body, 0, 200) . '...';
            }
        }

        $param_url = '';
        $all_params = explode('&', $_SERVER['QUERY_STRING']);
        $numOfPages = ceil(NoticeRepository::noticeCount()/$news_per_page);

        for($i=0;$i<count($all_params);$i++) {
            $a_params=explode("=", $all_params[$i]);
            if(count($a_params)!= 2){
                continue;
            }
            $key = $a_params[0];
            $value=urldecode($a_params[1]);

            if($key === 'p' && is_numeric($value) && $value>0 && $value <=$numOfPages){
                $pagination_page = $value;
            }
            else{
                if ($key == 'p' && $value == 0){
                    $pagination_page = '0';
                }
                else{
                    $param_url.= "$value/";
                }
            }
        }




        $this->viewmodel['numOfPages'] = $numOfPages;
        $this->viewmodel['param_url'] = $param_url;
        $this->viewmodel['r'] = $r;
        $this->viewmodel['breadcrumb']='oglasi';
        $this->viewmodel['meta']['title']='Oglasi';

        return $this->viewmodel;
    }

    public function getNotice(Router $r)
    {

        $this->viewmodel['news']=NoticeRepository::getNotice($r->id);
        $this->viewmodel['breadcrumb']='oglasi /'.$this->viewmodel['news']['main']->title;
        $this->viewmodel['meta']['title']='oglas -'.$this->viewmodel['news']['main']->title;
        return $this->viewmodel;
    }

    public function RenderContact(Router $r){
        $this->viewmodel['breadcrumb']=' kontakt ';
        $this->viewmodel['meta']['title']='Kontakt';
        return $this->viewmodel;
    }

    public function RenderArhiva(Router $r){
        $this->viewmodel['breadcrumb']=' arhiva ';
        return $this->viewmodel;
    }

    public function SearchResults(Router $r){
        $searched = Helper::ParseUrl();//vadi zahteve iz urla

        $aray = array_keys($searched);//uzima imena promenjivih iz zahteva
        $artVALUES = array();
        //smesta vrenosti u niz parametara po kojima se vrsi pretraga
        foreach ($aray as $attrid) {
            if ($attrid != 'page' && $attrid != 'id' && $attrid != 'p') {
                $artVALUES[$attrid] = $searched[$attrid];

            }
        }
        if(isset($artVALUES['searcht']) && isset($artVALUES['searched']))
        {
            $this->viewmodel['found']=array();
            $this->viewmodel['seach_type']="";

            switch($artVALUES['searcht'])
            {
                case 'vesti':{
                    $this->viewmodel['seach_type']='vesti';
                    $this->viewmodel['found']=NewsRepository::newsSearch($artVALUES['searched']);
                    break;
                }
                case 'javne':{

                    $this->viewmodel['seach_type']='javne';
                    $this->viewmodel['found']=JavneNabavkeRepository::javneSearch($artVALUES['searched']);
                    break;
                }
                case 'dokumenta':{

                    $this->viewmodel['seach_type']='dokumenta';
                    $this->viewmodel['found']=DokumentaRepository::docSearch($artVALUES['searched']);

                    break;
                }
            }
        }


        $this->viewmodel['seach']=$artVALUES;
        $this->viewmodel['breadcrumb']='rezultati pretrage';
        $this->viewmodel['meta']['title']='Rezultati pretrage';

        return $this->viewmodel;
    }



}