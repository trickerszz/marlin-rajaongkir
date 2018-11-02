<?php
require_once "marlin.class.php";
$marlin = new Marlin();

$jsonKota = $marlin->getKota();
$dataKota = json_decode($jsonKota,true);
$dataKota = $dataKota['rajaongkir']['results'];

if(isset($_POST['input'])){
    $kota = $_POST['kota'];
    $berat = $_POST['berat'];
    $kurir = $_POST['kurir'];
    $cost = $marlin->postCost("39",$kota,$berat,$kurir);
    $cost = json_decode($cost,true);
    $cost = $cost['rajaongkir'];

    echo "status : ".$cost['status']['code']." - ".$cost['status']['description'];
    echo "<br>";
    foreach ($cost['results'] as $value){
        echo "kurir : ".$value['name'];
        echo "<br>";
        if(count($value['costs'])>0){
            foreach ($value['costs'] as $item){
                echo "cost : ".$item;
            }
        }
        else{
            echo "harga tidak dapat diambil";
        }

    }
}

?>