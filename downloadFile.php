<?php
 class DownloadFile{
  public  function DownloadFile(){
    }
  public  function download($DLFile, $DLURL){
        $fp = fopen ($DLFile, 'w+');
        $ch = curl_init($DLURL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
}

?>