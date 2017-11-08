<?php
set_time_limit(0);
require "simple_html_dom.php";
require_once 'connection.php';

    //del
    // $url = "http://laptopprocom.vn/san-pham/lap-top/dell/106.html";
    //microsoft
    // $url = "http://laptopprocom.vn/san-pham/lap-top/microsoft/112.html";
    //Ổ cứng
$url = "http://fptcamera.vn/resources/stylesheets/client/";
    //microsoft
test();
// downloadImgSanpham1();
// dowload_javascript($url);
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
            echo $key->href;
            echo "<br/>";
        }
    }

    function downloadImgSanpham(){
        $db = new DB_Connection();
        $connection = $db->get_connection();
        $url = 'http://fptcamera.vn/resources/uploads/images/automatic/san-pham/';
        $html = file_get_html($url);

        $li = $html->find("li a");
        unset($li[0]);
        foreach ($li as $key) {
    		// download("./images/san-pham/".$key->href, $url.$key->href);
            http://fptcamera.vn/resources/js/client/jquery-2.1.3.min.js
            echo $key->href;
            echo "<br/>";
        }
    }

    function downloadImgSanpham1(){
        $db = new DB_Connection();
        $connection = $db->get_connection();
        $query = "select * from product";
        $url = 'http://fptcamera.vn/resources/uploads/images/automatic/san-pham/';

        $result = mysqli_query($connection,$query);
        $count = 0;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $img = $url.$row["img"];
                echo $row["id"].":---".$img;
                download("./images/a/".$row["img"], $img);
                echo "<hr/>";
                // $html = file_get_html($url);
                // $tins = $html->find("a[data-zoom-id]"); // lay hinh;
            }
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
    function test(){
        $fp = fopen (urldecode ("m%C3%A1+n%C3%B3"), 'w+');
        fclose($fp);
    }
    ?>