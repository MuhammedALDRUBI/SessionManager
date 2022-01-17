<?php

//SessionManager v 1.0
//this class helps you to maage your session and cookie to use it in Authuntication system

class SessionManager{

    //this properity will use to check if you start the session or not before doing any thing in $_SESSION arrat
    static private $OpenedSessionStatus = false;
    
    ///////////////////////////////////////////////////////////////////
    //this method will start the session 
    // session name will be LoginSession 
    //if $regenerateIdStatus has not been changed method will regenerate a new id for current session without remove any data from session
    //then OpenedSessionStatus static properity will be change to true ... that allow you to use other methodes without start session again 
    //you need to start session at least 1 time
    ///////////////////////////////////////////////////////////////////
    static public function StartLoginSession($regenerateIdStatus = true)
    {
        session_name("LoginSession");
        @session_start();
        if($regenerateIdStatus){session_regenerate_id();}
        self::$OpenedSessionStatus = true;
    }

     ///////////////////////////////////////////////////////////////////
    //this method will save an key and its value in $_SESSION array after checking if session has been start or not
    //  if key has been saved method will return true else will return false
    // $key is the name of key that will be saved in session array
    //$value is $key 's value that will be saved in session array
    //Note : $value must be associative array if you want to use it for login proccess by User.php and Auth system
    ///////////////////////////////////////////////////////////////////
     static public function SaveKeyInSession($key , $value){ 
        if(!self::$OpenedSessionStatus){ self::StartLoginSession(true);}
        $_SESSION[$key] = $value;
        if(array_key_exists($key , $_SESSION)){
            return true;
        }
            return false;
    }

    ///////////////////////////////////////////////////////////////////
    //this method will find an key and its value in $_SESSION array after checking if session has been start or not
    //  if key has been founded method will return it else will return null
    ///////////////////////////////////////////////////////////////////
     static public function FindKeyInSession($key){
        if(!self::$OpenedSessionStatus){ self::StartLoginSession(true);}
        if(array_key_exists($key , $_SESSION)){
            return $_SESSION[$key];
        }
        return null;
    }

     ///////////////////////////////////////////////////////////////////
    //this method will find an key and its value in $_SESSION array after checking if session has been start or not
    //  if $key has been founded method will  compare its value with $value  
    // if $value is identical to key ' value method will return true else will return false
    // $value ' value must be founded in key 's value.
    ///////////////////////////////////////////////////////////////////
    static public function CheckValueOfKeyInSession($key , $value){ 
        //Note : $value must be associative array and It must contain the same keys and values as in the $_SESSION array
        $valueOfKeyFromSession = self::FindKeyInSession($key);
        if($valueOfKeyFromSession == null){return false;}
        return count(array_intersect_assoc($value , $valueOfKeyFromSession)) == count($value);
    }

    ///////////////////////////////////////////////////////////////////
    //this method will find an key and its value in $_SESSION array after checking if session has been start or not
    //  if key has been founded method will remove it and return true , if it is not found a false will be returned
    ///////////////////////////////////////////////////////////////////
    static public function removeKeyFromSession($key){
        $valueOfKeyFromSession = self::FindKeyInSession($key);
        if($valueOfKeyFromSession == null){return false;}
        unset($_SESSION[$key]);
        return true;
    }

    ///////////////////////////////////////////////////////////////////
    //this method will truncate the $_SESSION array after checking if session has been start or not
    //and then will destroy the session 
    //if $pathToRedirect is not empty RedirectToPath method will be used to redirect the user to the path that has been passed
    ///////////////////////////////////////////////////////////////////
    static public function DestroySession($pathToRedirect = ""){
            if(!self::$OpenedSessionStatus){ self::StartLoginSession(true);}
            
            session_unset();
            session_destroy();
            if($pathToRedirect != ""){self::RedirectToPath($pathToRedirect);}
            return true;
    }

    ///////////////////////////////////////////////////////////////////
     //if $pathToRedirect is not empty RedirectToPath method will be used to redirect the user to the path that has been passed
    ///////////////////////////////////////////////////////////////////
    static public function RedirectToPath($pathToRedirect = ""){
        if($pathToRedirect != ""){header("location:" . $pathToRedirect); exit;}
    }

    ///////////////////////////////////////////////////////////////////
    //Cokkies Methodes
    ///////////////////////////////////////////////////////////////////

    static public function isCookieAvailable(){
        return count($_COOKIE) > 0;
    }
    ///////////////////////////////////////////////////////////////////
     //setDataInCookieForATime method will set a new cookie that defined in specific path and domain
     //$cookieName is the cookie's name that we want to set it
     //$cookieValue cookie value that will be stored in $cookieName key
     //$CookiePath is "/" by default (CokkiesPath = "/" in config file that come with login system that founded in the same GitHub account)
     //$domain is "localhost" by default .... type your domain or use a constant like i did
     //if you have a ssl cerificate $httpsStatus will be true ... here i wrote false
     //if you want to make your cookie only http defined $httpOnly will be true like i did
     //this method will return true or false 
    ///////////////////////////////////////////////////////////////////
    static public function setDataInCookieForATime($cookieName , $cookieValue , $expire  , $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly){
        $expire = $expire != null ? $expire : strtotime("+1 week"); // as Default 1 week if hasn't been changed
        if(count($_COOKIE) > 0){
            setcookie($cookieName , $cookieValue , $expire , $CookiePath , $domain , $httpsStatus , $httpOnly );
            if(self::FindDataInCookie($cookieName) != null){
                return true;
            }
            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////
    //this method will find a cookie by its name then return it if it is found else will return null 
    ///////////////////////////////////////////////////////////////////

    static public function FindDataInCookie($cookieName){
        if(count($_COOKIE) > 0){
            if(isset($_COOKIE[$cookieName])){return $_COOKIE[$cookieName];}
            return null;
        }
    }

    ///////////////////////////////////////////////////////////////////
    //this method will find a cookie by its name then remove it
    // after process is done method will return true
    //$cookieName is the cookie name that you want to remove it
    //other parameters is the same parameters that found in setDataInCookieForATime
    ///////////////////////////////////////////////////////////////////
    static public function UnsetDataFromCookie($cookieName ,  $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly){
        if(count($_COOKIE) > 0){
            if (isset($_COOKIE[$cookieName])) {
                unset($_COOKIE[$cookieName]); 
                setcookie($cookieName, null, -1, $CookiePath , $domain , $httpsStatus , $httpOnly); 
            } 
            return true;
        }
    }
 

}