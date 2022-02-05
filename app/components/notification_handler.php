<?php

if(isset($_SESSION['mail_send'])){
    if($_SESSION['mail_send']){
        echo '<script type="text/javascript">'
        , 'showNotification("Uspesno poslata poruka", "success");'
        , '</script>'

        ;
    }
    else{
        echo '<script type="text/javascript">'
        , 'showNotification("Neuspelo slanje poruke", "error");'
        , '</script>'
        ;
    }
    unset($_SESSION['mail_send']);
}

if(isset($_SESSION['error_notifications']))
{
    $mesages=$_SESSION['error_notifications'];
    foreach ( $mesages as $msg ) {
        echo '<script type="text/javascript">'
        , 'alertify.error("'.$msg.'");'
        , '</script>'
        ;

    }
    unset($_SESSION['error_notifications']);

}


if(isset($_SESSION['success_notifications']))
{
    $mesages=$_SESSION['success_notifications'];
    foreach ( $mesages as $msg ) {
        echo '<script type="text/javascript">'
        , 'alertify.success("'.$msg.'");'
        , '</script>'
        ;

    }
    unset($_SESSION['success_notifications']);

}

?>