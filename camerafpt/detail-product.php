<?php
set_time_limit(0);
require_once 'connection.php';
require "simple_html_dom.php";

update_detail();

function getDom($url){

	// $url = "http://fptcamera.vn/lap-dat-camera-gia-re-bo-1-den-8-mat";

	$html = file_get_html($url);

	$chitiet = $html->find("div#chitiet",0);
	$thongso = $html->find("div#thongso",0);
	$chitiet_UTF8 = htmlentities($chitiet, ENT_COMPAT, "UTF-8");
	$thongso_UTF8 = htmlentities($thongso, ENT_COMPAT, "UTF-8");
	$sql = "UPDATE product SET detail_product=\"$chitiet_UTF8\" digital=\"$thongso_UTF8\" WHERE id=2";
	// $arrImg = $chitiet->find("img");
	// foreach ($arrImg as $key) {
	// 	$img = basename($key->src);
	// 	// download("./resources/uploads/images/".$img, "http://fptcamera.vn/resources/uploads/images/".$img);
	// }
	// echo $chitiet;
	// echo "<hr/>";
	// echo $thongso;


}


function update_detail(){
	$db = new DB_Connection();
	$connection = $db->get_connection();
	$query = "select * from product";

	$result = mysqli_query($connection,$query);
	$count = 0;
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$url = $row["link"];
			// getDom($url);
			$html = file_get_html($url);

			$chitiet = $html->find("div#chitiet",0);
			$thongso = $html->find("div#thongso",0);
			$chitiet_UTF8 = htmlentities($chitiet, ENT_COMPAT, "UTF-8");
			$thongso_UTF8 = htmlentities($thongso, ENT_COMPAT, "UTF-8");
			$sql = "UPDATE product SET detail_product=\"$chitiet_UTF8\", digital=\"$thongso_UTF8\"  WHERE id=".$row["id"];
			// if (mysqli_query($connection, $sql)) {
			// 	echo "Record updated successfully";
			// } else {
			// 	echo "Error updating record: " . mysqli_error($connection);
			// }
			echo $row["id"]." xong <br/>";
			// echo html_entity_decode($row["digital"]);
                // $html = file_get_html($url);
                // $tins = $html->find("a[data-zoom-id]"); // lay hinh;
		}
		mysqli_close($connection);
	}
}

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