<?php
    // Include the Library & You can change the alias of Namespace as anything, I used Curl
    require_once __DIR__."/K2Curl.php";
    use Curl\K2_CURL as Curl;
    
    // CHECK IF FORM IS POST & Contains Value in url Input
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["url"])) {
        $url = $_POST["url"];
        if (!empty($url)) {
            
            // -------- HOW TO USE THE CURL LIBRARY -------- //
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
            
            // Just For Showing Results
            echo '<pre>';
            print_r($result["error"]);
            echo '</pre><pre>';
            echo "<p><b>Total Result = " . count($returnData) . "</b><br><hr>";
            print_r($returnData);
            echo '</pre>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <!-- Title tags -->
        <title>CURL Library
        </title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
        <!-- Optional theme -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap");
            body {
                background: rgba(246, 246, 247, 1);
                color: rgba(32, 34, 35, 1);
                font-family: "Ubuntu", sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xs-12 col-sm-6" style="margin-top: 1%">
                <form method="post" action="#">
                    <div class="form-group row">
                        <label for="text" class="col-3 col-form-label">URL</label>
                        <div class="col-9">
                            <div class="input-group">
                                <input id="url" name="url" type="text" class="form-control" value="https://jsonplaceholder.typicode.com/posts" required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-3 col-form-label">Data 1</label>
                        <div class="col-9">
                            <div class="input-group">
                                <input id="data1" name="data1" type="text" class="form-control" value="Basant"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-3 col-form-label">Data 2</label>
                        <div class="col-9">
                            <div class="input-group">
                                <input id="data2" name="data2" type="text" class="form-control" value="Mandal"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-center">
                            <button class="btn btn-info">SEND CURL REQUEST</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
