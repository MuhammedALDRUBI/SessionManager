<h1>SessionManager</h1>
<h2>this class helps you to maage your session and cookie to use it in Authuntication system</h2>

usable Methodes :

- StartLoginSession($regenerateIdStatus = true)
- SaveKeyInSession($key , $value)
- FindKeyInSession($key)
- CheckValueOfKeyInSession($key , $value)
- removeKeyFromSession($key)
- DestroySession($pathToRedirect = "")
- RedirectToPath($pathToRedirect = "")
- setDataInCookieForOneYear($userInfoArray , $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly)
- FindDataInCookie($cookieName)
- UnsetDataFromCookie($cookieName ,  $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly)

<hr>

1 - StartLoginSession($regenerateIdStatus = true)

this method will start the session 
session name will be LoginSession 
if $regenerateIdStatus has not been changed method will regenerate a new id for current session without remove any data from session
then OpenedSessionStatus static properity will be change to true ... that allow you to use other methodes without start session again 
you need to start session at least 1 time

<hr>

2- SaveKeyInSession($key , $value)

this method will save an key and its value in $_SESSION array after checking if session has been start or not
if key has been saved method will return true else will return false
$key is the name of key that will be saved in session array
$value is $key 's value that will be saved in session array
<b>Note : $value must be associative array if you want to use it for login proccess by User.php and Auth system</b>

ex : 
$key = "user";
$value = array("name" => "Muhammed" , "email" => "anyEmail@gmail.com" , "phoneNumber" => "055555555");
SessionManager::SaveKeyInSession($key , $value);

<hr>

3 - FindKeyInSession($key)

this method will find an key and its value in $_SESSION array after checking if session has been start or not
if key has been founded method will return it else will return null

<hr>

4 - CheckValueOfKeyInSession($key , $value)

 this method will find an key and its value in $_SESSION array after checking if session has been start or not
if $key has been founded method will  compare its value with $value  
if $value is identical to key ' value method will return true else will return false
$value 's value must be founded in key 's value.

<hr>

5 - removeKeyFromSession($key)
this method will find an key and its value in $_SESSION array after checking if session has been start or not
if key has been founded method will remove it and return true , if it is not found a false will be returned

<hr>

6 - DestroySession($pathToRedirect = "")
this method will truncate the $_SESSION array after checking if session has been start or not and then will destroy the session 
if $pathToRedirect is not empty RedirectToPath method will be used to redirect the user to the path that has been passed

<hr>

7 - RedirectToPath($pathToRedirect = "")

if $pathToRedirect is not empty RedirectToPath method will be used to redirect the user to the path that has been passed

<hr>

8 - setDataInCookieForOneYear($userInfoArray , $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly)

setDataInCookieForOneYear method will set a new cookie ((Not : here we use it to set a user info in cookie to use it in login process))
$userInfoArray is an user 's information associative array ..... user 's email and his password will be taked from this array
then a cookie with name =  UserEmail and other cookie with name =  UserPassword
$CookiePath is "/" by default (CokkiesPath = "/" in config file that come with login system that founded in the same GitHub account)
$domain is "localhost" by default .... type your domain or use a constant like i did
if you have a ssl cerificate $httpsStatus will be true ... here i wrote false
if you want to make your cookie only http defined $httpOnly will be true like i did
this method will return true or false 

ex : 
$userInfoArray = array("Password" => 224422 , "Email" => "anyEmail@gmail.com" , "phoneNumber" => "055555555");
define("CokkiesDomain" , "localhost");
define("CokkiesPath" , "/");
define("httpsStatus" , false);
define("CookieshttpOnly" , true);
SessionManager::setDataInCookieForOneYear($userInfoArray , $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly)

now UserEmail 's cookie and UserPassword 's cookie will be saved in http cookie and its expires will be one year
<hr>

9- FindDataInCookie($cookieName)
this method will find a cookie by its name then return it if it is found else will return null 

<hr>

10 - UnsetDataFromCookie($cookieName ,  $CookiePath = CokkiesPath , $domain = CokkiesDomain , $httpsStatus = httpsStatus , $httpOnly = CookieshttpOnly)
this method will find a cookie by its name then remove it
after process is done method will return true
$cookieName is the cookie name that you want to remove it
other parameters is the same parameters that found in setDataInCookieForOneYear
