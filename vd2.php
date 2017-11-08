<?php
    require_once 'connection.php';
    require "simple_html_dom.php";
    
    //del
    // $url = "http://laptopprocom.vn/san-pham/lap-top/dell/106.html";
    //microsoft
    // $url = "http://laptopprocom.vn/san-pham/lap-top/microsoft/112.html";
    //Ổ cứng
    $url = "http://fptcamera.vn/resources/stylesheets/client/";
    //microsoft

    dowload_javascript($url);
    // dowloadCSS($url);
    function dowload_javascript($url){
        $html = file_get_html('http://fptcamera.vn/resources/js/client/');
    
        $li = $html->find("li a");
        unset($li[0]);
        foreach ($li as $key) {
            download("./js1/".$key->href, "http://fptcamera.vn/resources/js/client/".$key->href);
            echo $key->href;
            echo "<br/>";
        }
    }

    function dowloadCSS($url){
        $html = file_get_html($url);
    
        $li = $html->find("li a");
        unset($li[0]);
        foreach ($li as $key) {
            download("./stylesheets/".$key->href, "http://fptcamera.vn/resources/stylesheets/client/".$key->href);
            http://fptcamera.vn/resources/js/client/jquery-2.1.3.min.js
            echo $key->href;
            echo "<br/>";
        }
    }

    //$tins = $html->find("li[hinhphu]");

    function download($DLFile, $DLURL){
        $fp = fopen ($DLFile, 'w+');
        $ch = curl_init($DLURL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
   
?>