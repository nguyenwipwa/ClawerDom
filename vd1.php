<?php
    require_once 'connection.php';
    require "simple_html_dom.php";
    $db = new DB_Connection();
    //del
    // $url = "http://laptopprocom.vn/san-pham/lap-top/dell/106.html";
    //microsoft
    // $url = "http://laptopprocom.vn/san-pham/lap-top/microsoft/112.html";
    //Ổ cứng
    $url = "http://laptopprocom.vn/san-pham/phu-kien/o-cung/119.html";
    //microsoft
    
    $html = file_get_html($url);

    $tins = $html->find("li[hinhphu]");
    $connection = $db->get_connection();

    foreach($tins as $t){
        $row = $t->innertext();
        $html_row = str_get_html($row);

        $name =  trim($html_row->find("a")[0]->text());
        $price =  convert(trim($html_row->find("div.gia")[0]->text()));
        $img =  trim($html_row->find("a img")[0]->src);
        $link =  trim($html_row->find("a")[0]->href);
        echo "<h3>Name: </h3>".trim($name);
        echo "<h3>Price: </h3>".$price;
        echo "<h3>Img: </h3><img src='$img'/> <br/>".$img;
        echo "<h3>Link: </h3> http://laptopprocom.vn/".$link;
        echo "<hr/>";
        $query = "Insert into product values ('0','$name','$price','$img',1,'$link')";
        $result = mysqli_query($connection,$query);
        $url_image = "http://laptopprocom.vn/$img";
        $img_download = "/$img";
        // download($img_download,$url_image);
        
        // foreach($mang as $r){
        //     echo $r;
        // }
    }
    echo "xong";
    function convert($priceConvert){
        $a = explode('.', trim($priceConvert));
        $price = "";
            foreach($a as $r){
                 $price .=$r;
            }
        $b = explode(" ", trim($price)); 
        return intval($b[0]);
    }
    function download($img_download,$url_image){
        file_put_contents($img_download, file_get_contents($url_image));
    }

?>