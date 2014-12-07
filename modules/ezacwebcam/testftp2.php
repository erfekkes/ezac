<?php

//Get them file!
echo "Collecting Files<br>";

//Set defaults just in case. PHP complains anyway if we don't.
$dir = "webcam";

function filecollect($cid,$dir='.') {
  static $flist=array();
  if ($files = ftp_nlist($cid,$dir)){
    foreach ($files as $file) {
      if (ftp_size($cid, $file) == "-1"){
        filecollect($cid,$file);
	//echo "[" .$file ."]<br>";
      } else {
	list($webcam, $dir, $filename) = explode("/",$file);
	$flist[$dir][] = $file;
	}
    }
  }
  return $flist;
}

$conn_id = ftp_connect('efekkes.dyndns.org') or die("Couldn't connect to server");
  if (@ftp_login($conn_id, 'webcam', 'ezacwebcam')){
    ftp_pasv($conn_id, TRUE); //Passive Mode is better for this
    $filelist = filecollect($conn_id, $dir);
    echo "<pre>";
      //print_r($filelist);
    echo "</pre>";

    foreach($filelist as $dirlist) {
      $file = $dirlist[0];
      list($webcam, $dir, $filename) = explode("/",$file);
      echo "[" .$dir ."] " .count($dirlist) ."<br>";
      echo "<img src='ftp://webcam:ezacwebcam@efekkes.dyndns.org/" .$file ."' width=120><br>";
      foreach($dirlist as $file) {
	  }
  //    echo "<img src='ftp://webcam:ezacwebcam@efekkes.dyndns.org/" .$file ."' width=40>";
    }

  }

?>