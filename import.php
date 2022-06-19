<?php
// POŁĄCZENIE Z BAZĄ
$dbhost = "localhost";
$dbname = "test";
$dbchar = "utf8";
$dbuser = "root";
$dbpass = "";
$pdo = new PDO(
    "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar",
    $dbuser, $dbpass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);


// CZYTANIE ZUPLOADOWANEGO CSV
$fh = fopen($_FILES["upcsv"]["tmp_name"], "r");
if ($fh===false) {
    exit("Error, We can't open CSV file");
}

// IMPORTOWANIE WIERSZ PO WIERSZU
while (($row = fgetcsv($fh)) !== false) {
    try {
        $stmt = $pdo->prepare("INSERT INTO `usr` (`user_name`,`user_date`) VALUES (?,?)");
        $stmt->execute([
            $row[0], $row[1]
        ]);
    }
    catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

//GOTOWE
fclose($fh);

echo "GOTOWE!";




