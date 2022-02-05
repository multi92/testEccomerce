<?php

/* not in use	*/
/*
class Session
{
    public static function StartSession(){
        session_start();
    }

    public static function DestroySession(){
        session_destroy();
    }

    public static function SetVarVal($key,$value)
    {
        $_SESSION[$key]=$value;
    }

    public static function SetArrVal($key,$index,$value)
    {
        $_SESSION[$key][$index]=$value;
    }

    public static function SetArrValNext($key,$value)
    {
        $_SESSION[$key][]=$value;
    }

    public static function SetMatVal($key,$index,$index1,$value)
    {
        $_SESSION[$key][$index][$index1]=$value;
    }

    public static function GetMatVal($key,$index,$index1)
    {

        if(isset($_SESSION[$key][$index][$index1])){
            return $_SESSION[$key][$index][$index1];
        }
    }

    public static function GetVarVal($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
//        else{
//            throw new Exception("Session variable with key:".$key." doesn`t exist.");
//        }
    }

    public static function GetArrVal($key,$index)
    {

        if(isset( $_SESSION[$key][$index])){
            return  $_SESSION[$key][$index];
        }
//        else{
//            throw new Exception("Session arr variable with key:".$key." and index: ".$index." doesn`t exist.");
//        }
    }

    public static function UnsetVar($key)
    {
        if(isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        }
    }

    public static function UnsetArr($key,$index)
    {
        if(isset($_SESSION[$key][$index]))
        {
            unset($_SESSION[$key][$index]);
        }
    }

    public static function IssetVar($key)
    {
        if(isset($_SESSION[$key]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
*/