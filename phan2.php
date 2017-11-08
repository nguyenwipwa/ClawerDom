<?php
//boc dểction
    require_once 'connection.php';
    require "simple_html_dom.php";
    require 'downloadFile.php';
    $db = new DB_Connection();
    $download = new DownloadFile();
    //del
    $host_url = "http://laptopprocom.vn/";
    //microsoft
    // $url = "http://laptopprocom.vn/san-pham/lap-top/microsoft/112.html";
    
    $connection = $db->get_connection();
    mysqli_set_charset($connection,"utf8");
    
//$GetCurrent
    $query = "select id,link from product limit 0, 50";
    $result = mysqli_query($connection,$query);
    $count = 0;
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $url = $host_url.$row["link"];
            $html = file_get_html($url);
            $tins = $html->find("a[data-zoom-id]"); // lay hinh;
            //duyetMangDownload($tins,$download);
            //  duyetMang($tins, $row["id"],$connection, $count );
            //  duyetMangLayDescription($html,$row["id"],$connection); //lay mo ta
            // break;
        }
        echo "xong";
    }
    
    function duyetMang($a, $id,$connection,$count){
        foreach($a as $r){
           $imgChilren = trim(basename($r->href));
            // echo "<img src='http://laptopprocom.vn/$imgChilren'/>";
            $query2 = "insert into img_children value(0,'$imgChilren', $id)";
            $result2 = mysqli_query($connection,$query2);
            $count+=1;
            echo "<hr/>";
            echo basename($imgChilren);
        }
        echo "<hr/>";
        echo $count. " :==========";
    }
      function duyetMangDownload($a, $download){
        foreach($a as $r){
           $imgChilren = trim(basename($r->href));
           $url = "http://laptopprocom.vn/".$r->href;
           $download->download("./upload/product_children/".$imgChilren,$url );
            echo "<hr/>";
            echo $url;
        }
        echo "<hr/>";
    }
    function duyetMangLayDescription($html, $id, $connection){
            $detail = $html->find("div.info_left")[0]->innertext();
            $code = trim(str_get_html($detail)->find("div.row_detail")[2]->find("span.noidung")[0]->text()); //ma code
            $detail1 = trim((count(str_get_html($detail)->find("div.row_detail1 ul"))==0) ? "Chưa có chi tiết" : str_get_html($detail)->find("div.row_detail1 ul")[0]->innertext()); //ma code
            $description = $html->find("div.ctab2")[0];
            $mota = $html->find("div.ctab1")[0];

            $detail1_UTF8 = htmlentities($detail1, ENT_QUOTES, "UTF-8");
            $mota_UTF8 = htmlentities($mota, ENT_QUOTES, "UTF-8");
            $description_UTF8 = htmlentities($description, ENT_QUOTES, "UTF-8");

            $query2 = "insert into product_detail value(0,'$code','$detail1_UTF8', '$description_UTF8','$mota_UTF8', $id)";
            // $result2 = mysqli_query($connection,$query2);
            // echo ($code);
            // echo "<br/> <br/>";
            // echo ($detail1);
            // echo "<br/>";
            // echo ($description);
            // echo "<br/> <br/>";
            // echo ($mota);
            // echo "<br/> <br/>";
            // echo "<hr/>";
    }


//$GetCurrent
    

    // foreach($tins as $t){
    //     $row = $t->innertext();
    //     $html_row = str_get_html($row);

    //     $name =  trim($html_row->find("a")[0]->text());
    //     $price =  convert(trim($html_row->find("div.gia")[0]->text()));
    //     $img =  trim($html_row->find("a img")[0]->src);
    //     $link =  trim($html_row->find("a")[0]->href);
    //     echo "<h3>Name: </h3>".trim($name);
    //     echo "<h3>Price: </h3>".$price;
    //     echo "<h3>Img: </h3><img src='$img'/> <br/>".$img;
    //     echo "<h3>Link: </h3> http://laptopprocom.vn/".$link;
    //     echo "<hr/>";
    //     $query = "Insert into product values ('0','$name','$price','$img',1,'$link')";
    //     // $result = mysqli_query($connection,$query);
    //     $url_image = "http://laptopprocom.vn/$img";
    //     $img_download = "/$img";
    //     // download($img_download,$url_image);
        
    //     // foreach($mang as $r){
    //     //     echo $r;
    //     // }
    // }
    // echo "xong";
    // function convert($priceConvert){
    //     $a = explode('.', trim($priceConvert));
    //     $price = "";
    //         foreach($a as $r){
    //              $price .=$r;
    //         }
    //     $b = explode(" ", trim($price)); 
    //     return intval($b[0]);
    // }
    // function download($img_download,$url_image){
    //     file_put_contents($img_download, file_get_contents($url_image));
    // }

?>