<?php
require './simple_html_dom.php';
require './connection.php';
require './downloadFile.php';

$db = new DB_Connection();
$connection = $db->get_connection();

$url = "http://www.sieuthivienthong.com/";

$html = file_get_html($url);
$tins = $html->find("div.sub_prod_home");
// duyetMangIn($tins);

// b1:tao category va sub_category
//  duyetDanhMuc($html, $connection);
// subMenuChoCamera($connection);
//b2:  insert du lieu vao product:
    // insertProduct($connection);
//b3: Insert du lieu vao detail.
    // insertProduct_detail($connection);
    //b4: download hinh anh;

// danhMucNho(file_get_html("http://www.sieuthivienthong.com/camera-quan-sat/19/category.html"), null, null);

echo "XOng";
mysqli_close($connection);

function duyetMangIn($a){
    foreach($a as $r){
        echo $r;
        echo "<hr/>";
    }
}
class Category{
    public $id, $name, $link;
    function __construct($id, $name, $link){
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
    }
}


function duyetDanhMuc($html, $connection){
    $arrayCate = [];
    $url = "http://www.sieuthivienthong.com";
    $cat = $html->find("li.cat ");
    $id = 1;
    foreach($cat as $r){
        $name = trim($r->text());
        $link = trim($r->find("a",0)->href);
        $cate = new Category($id, $name, $link);
        // echo $cate->name." id: ".$id;
        // echo "<br/>";
        $query = "insert into category_product values(0,'$name','$link');";
        insert($connection, $query);
        $id = mysqli_insert_id($connection);
        // echo $link;
        // array_push($arrayCate, $cate);
        // echo "<hr/>";
        danhMucNho(file_get_html($url.$link), $id, $connection);
        break;
        }
    }

    function danhMucNho($html, $id, $connection){
        danhMucSubCat($html, $id, $connection);
        // echo "<hr/>";
    }
    function danhMucSubCat($html, $id, $connection){
        $url = "http://www.sieuthivienthong.com";
        $arrayCate = [];
        $cat = $html->find("a.sub-cat-menu");
        foreach($cat as $r){
            $name = trim($r->text());
            $link = trim($r->href);
            // echo $name;
            // echo "<br/>";
            // echo $link;
            // echo "<br/>";
            // $query = "insert into category_sub values(null,'$name', $id, null, '$link');";
            // echo $query;
            // insert($connection, $query);
            // $id = mysqli_insert_id($connection);
            // array_push($arrayCate, $cate);
            // getContent($link, $id, $connection);
            break;
        }
    }
    function subMenuChoCamera($connection){
        $url = "http://www.sieuthivienthong.com/camera-quan-sat/19/category.html";
        $html = file_get_html($url);
        $cat = $html->find("a.sub-cat-filter");
        foreach($cat as $r){
            $name = trim($r->text());
            $query = "insert into cate_filter values(null,'$name',null);";
            // echo $url;
            insert($connection, $query);
            // echo $name;
            // echo "<br/>";
           
        }
    }
    function insert($connection,$query){
        $result2 = mysqli_query($connection,$query);
    }

////////connect mYsql

    function insertProduct($connection){
        $url = "http://www.sieuthivienthong.com";
        $query = "select id,link from category_sub limit 128, 600";
        $result = mysqli_query($connection,$query);
        $count = 0;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $link = $url.$row["link"];
                $id = $row["id"];
                getContent($link, $connection, $id);
                echo $link;
                echo "<hr/>";
                // $html = file_get_html($url);
                // $tins = $html->find("a[data-zoom-id]"); // lay hinh;
            }
        echo "\nxong";
    }
}

    function getContent($link, $connection, $id){
        $html = file_get_html($link);
        $tins = $html->find("div.sub_prod_home");
        echo "=============".count($tins);
        foreach($tins as $r){
            $name = trim($r->find("a",0)->title);
            $img = basename(trim($r->find("img.w_100",0)->src));
            $des_home = trim($r->find("div.des_prod_home",0)->text());
            $price = convert(trim($r->find("span.nb_price_prod_home",0)->text()));
            $link = trim($r->find("a",0)->href);
            // echo "<br/>";
            // echo $des_home;
            // echo "<br/>";
            // echo $price;
            // echo "<br/>";
            // echo $link;
            // echo "<br/>";
            // echo $name;
            // echo "<hr/>";
            $query = "insert into product values(null,'$name','$des_home',$price,'$img','$link', $id);";
            // echo $query;
            // insert($connection, $query);
            // break;
        }
    }
    function convert($priceConvert){
        $a = explode('.', trim($priceConvert));
        $price = "";
            foreach($a as $r){
                 $price .=$r;
            }
        $b = explode(" ", trim($price)); 
        return intval($b[0]);
    }

    function insertProduct_detail($connection){
        $url = "http://www.sieuthivienthong.com";
        $query = "select id,link,img from product limit 100, 12200";
        $result = mysqli_query($connection,$query);
        $count = 0;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $link = $url.$row["link"];
                $id = $row["id"];
                $img = "http://www.sieuthivienthong.com/imgs/art/".$row["img"];
                getContent_detail($link, $connection, $id);
                // $img2 = basename($img);
                // download("./img_mini/$img2", $img);
                // echo $img2;
                echo "<hr/>";
                // break;
            }
        echo "\nxong";
    }
}
function getContent_detail($link, $connection, $id){
    $html = file_get_html($link);
    $tins = $html->find("div.conten_prod_t",0);// lay detail
    $tins1 = basename($html->find("div img.w_100", 1)->src);// lay detail
    // foreach($tins as $r){
    //     echo "<img src='http://www.sieuthivienthong.com$r->src'/>";
    //     echo "<hr/>";
    // }
        // echo "<img src='http://www.sieuthivienthong.com$tins'/>";
    
    // echo count($tins);
    // $url_img = "http://www.sieuthivienthong.com".$tins;
    // download("./img/".basename($url_img), $url_img);
    // echo $tins;
        $description_UTF8 = htmlentities($tins, ENT_COMPAT, "UTF-8");
        // echo html_entity_decode($description_UTF8);
        $query = "insert into product_detail values(null,\"$description_UTF8\",'$tins1',$id);";
        insert($connection, $query);
}

?>