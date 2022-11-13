<?php
$time = microtime(true);
$dir = 'kitab';
if(isset($_GET['kitab']) and isset($_GET['id']) and is_numeric($_GET['id'])){
  $kitab = $_GET['kitab'];
  $id = abs((int)$_GET['id']);
  if(file_exists("$dir/$kitab") and $id <= count(file("$dir/$kitab"))){
    $array = explode('|', file("$dir/$kitab")[$id - 1]);
    $hasil = [
      'kitab'=>$kitab,
      'id'=>$id,
      'nass'=>trim($array[2]),
      'terjemah'=>trim($array[3])
    ];
    $output = ['ok'=>true,'hasil'=>$hasil, 'durasi'=> hitungDurasi($time)];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
  }else{
    echo kosong();
  }
}


elseif(isset($_GET['q']) and !empty($_GET['q'])){
  $query = urldecode($_GET['q']);
  if(empty($query))exit('query kosong');
  $files = "$dir/*_*";
  $hasil = [];
  foreach(glob($files) as $file){
    $nohadis = [];
    foreach(file($file) as $no => $baris){
      if(strpos($baris, $query) !== false){
        $nohadis[] = $no + 1;
      }
    }
    if(count($nohadis)>0){
      $hasil[] = [basename($file)=>$nohadis];
    }
  }
  if(count($hasil)>0){
    echo json_encode( ['ok'=>true, 'hasil'=>$hasil, 'durasi'=>hitungDurasi($time)] );
  }else{
    echo kosong();
  }
}

else{
  echo "<pre>parameter: q atau kitab & id\nContoh:\nhttps://hadisdb.dananghp7.repl.co/?q=puasa+ramadhan\nhttps://hadisdb.dananghp7.repl.co/?kitab=Shahih_Bukhari&id=1</pre><a href='kitab/'>Daftar Kitab</a>";
}

function kosong(){
  global $time;
  return json_encode(['ok'=>false, 'hasil'=>'hadis tidak ditemukan', 'durasi'=>hitungDurasi($time)]);
}

function hitungDurasi($time){
  return microtime(true) - $time;
}