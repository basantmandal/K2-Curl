# K2 Curl - PHP - CURL Library

Easy Light Weight - PHP > 5.6 based CURL Library, Can be customized based on your needs.
This K2 Curl Library helps in Sending HTTP requests and can be integrated with PHP based Web APIs

## Features
    * Easy & Lightweight
    * PHP 7 Compatible
    * Easy to use.

**How can you use for test or learning purpose ? You can go through the index.php or else read below**

**Usage

// -------- HOW TO USE THE CURL LIBRARY -------- //
    // Include the Library & You can change the alias of Namespace as anything, I used Curl
    require_once __DIR__."/K2Curl.php";
    use Curl\K2_CURL as Curl;
   
    $data = array("data1" => $_POST["data1"], "data2" => $_POST["data2"]);

    // CREATE A OBJECT OF K2_CURL Class
    $obj        = new Curl($url, "GET", $data, "");

    // ADDS SERVER AUTHENTICATION - If Required
    $obj->set_authentication("username", "password");

    // ADDS UserAgent - If Required
    $obj->set_userAgent('Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0');

    // INITIALISE/EXECUTE CURL - This is the last function to call after adding you add any Authentication & User Agent
    $result     = $obj->execCurl();

    // RETURNS ARRAY(error, output)
    $returnData = json_decode($result["output"]);
    // ------------------------------------------- //




Please note:- **This plugin is under development.**
