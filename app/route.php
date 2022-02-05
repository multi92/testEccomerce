<?php


//Get requests
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $router = new Router();
    switch ($router->page) {
        case 'home': {
            $router->RenderPage('home', 'ShowCTRL', 'RenderHome');
            break;
        }

        case 'mirisi': {
            $router->RenderPage('mirisi', 'ShowCTRL', 'RenderMirisi');
            break;
        }

        case 'novo': {
            $router->RenderPage('novo', 'ShowCTRL', 'RenderNovo');
            break;
        }

        case 'proizvodi': {
            $router->RenderPage('proizvodi', 'ShowCTRL', 'RenderProizvodi');
            break;
        }
        case 'proizvod': {
            $router->RenderPage('proizvod', 'ShowCTRL', 'RenderProizvod');
            break;
        }
        case 'kategorije': {
            $router->RenderPage('kategorije', 'ShowCTRL', 'RenderKategorije');
            break;
        }
        case 'pretraga': {
            $router->RenderPage('pretraga', 'ShowCTRL', 'RenderPretraga');
            break;
        }
        case 'mojnalog': {
            $router->RenderPage('mojnalog', 'ShowCTRL', 'RenderMojNalog');
            break;
        }
        case 'displays': {
            $router->RenderPage('displays', 'ShowCTRL', 'RenderDisplays');
            break;
        }
        case 'personalizedperfumes': {
            $router->RenderPage('personalizedperfumes', 'ShowCTRL', 'RenderPersonalizedPerfumes');
            break;
        }
        case 'quality': {
            $router->RenderPage('quality', 'ShowCTRL', 'RenderQuality');
            break;
        }
        case 'onama': {
            $router->RenderPage('onama', 'ShowCTRL', 'RenderOnama');
            break;
        }
        case 'available_shapes': {
            $router->RenderPage('available_shapes', 'ShowCTRL', 'RenderAvailable_shapes');
            break;
        }
        case 'cellulose_samples': {
            $router->RenderPage('cellulose_samples', 'ShowCTRL', 'RenderCellulose_samples');
            break;
        }
        case 'bottle_shapes': {
            $router->RenderPage('bottle_shapes', 'ShowCTRL', 'RenderBottle_shapes');
            break;
        }
        case 'registerconf': {
            $router->RenderPage('registerconf', 'ShowCTRL', 'RenderRegisterconf');
            break;
        }

        case 'user':{
            $router->RenderPage('user','ShowCTRL','RenderUser');
            break;
        }

        case 'javne':{
            $router->RenderPage('javne','ShowCTRL','RenderJavne');
            break;
        }
        case 'ustanova':{
            $router->RenderPage('ustanova','ShowCTRL','RenderUstanova');
            break;
        }
        case 'dokumenta':{
            $router->RenderPage('dokumenta','ShowCTRL','RenderDokumenta');
            break;
        }

        case 'vesti':{
            $router->RenderPage('vesti','ShowCTRL','getAllNews');
            break;
        }

        case 'vest':{
            $router->RenderPage('vest','ShowCTRL','getNews');
            break;
        }
        case 'strana':{
            $router->RenderPage('strana','ShowCTRL','GetSimplePage');
            break;
        }

        case 'foto-galerija': {
            $router->RenderPage('foto-galerija','ShowCTRL','RenderPhotoGallery');
            break;
        }
        case 'foto-galerije': {
            $router->RenderPage('foto-galerije','ShowCTRL','RenderPhotoGallerys');
            break;
        }

        case 'video-galerija': {
            $router->RenderPage('video-galerija','ShowCTRL','RenderVideoGallery');
            break;
        }

        case 'video-galerije': {
            $router->RenderPage('video-galerije','ShowCTRL','RenderVideoGallerys');
            break;
        }

        case 'oglasi':{
            $router->RenderPage('oglasi','ShowCTRL','getAllNotices');
            break;
        }
        case 'oglas':{
            $router->RenderPage('vest','ShowCTRL','getNotice');
            break;
        }
        case 'kontakt':{
            $router->RenderPage('kontakt','ShowCTRL','RenderContact');
            break;
        }

        case 'arhiva':{
            $router->RenderPage('arhiva','ShowCTRL','RenderArhiva');
            break;
        }

        case 'pretraga':{
            $router->RenderPage('search_res','ShowCTRL','SearchResults');
            break;
        }

    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){


    $post_handle=new PostRequestHandler();
}

?>