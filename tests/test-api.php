<?php
$url = "https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml";
$data = simplexml_load_file($url);

$gempa = $data->gempa;

$result = [
    "tanggal"   => (string)$gempa->Tanggal,
    "jam"       => (string)$gempa->Jam,
    "datetime"  => (string)$gempa->DateTime,
    "magnitude" => (string)$gempa->Magnitude,
    "kedalaman" => (string)$gempa->Kedalaman,
    "lintang"   => (string)$gempa->Lintang,
    "bujur"     => (string)$gempa->Bujur,
    "wilayah"   => (string)$gempa->Wilayah,
    "potensi"   => (string)$gempa->Potensi,
    "dirasakan" => (string)$gempa->Dirasakan,
    "shakemap"  => "https://static.bmkg.go.id/" . $gempa->Shakemap
];

// Print JSON (for API use)
header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
?>