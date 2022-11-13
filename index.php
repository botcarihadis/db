<?php
$file = 'hadisdb/Shahih_Bukhari';
$array = file($file);
foreach($array as $no => $baris){
  if(strpos($baris, 'puasa') !== false){
    echo $no." ";
    // break;
  }
}