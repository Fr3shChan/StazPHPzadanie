
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

// TWORZENIE TABLICY W BAZIE DANYCH
$dbc = mysqli_connect('localhost','root','','test');

$sql = "CREATE TABLE usr (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255),
    user_date DATE)";

$result = mysqli_query($dbc, $sql) or die ("Nie stworzono");

// UPLOAD PLIKU CSV
$fh = fopen("E:\csv\php_internship_data.csv", "r");
if ($fh===false) {
    exit("Jest problem z odczytaniem tego pliku CSV");
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
fclose($fh);

echo "GOTOWE!";

// ŁĄCZENIE Z BAZĄ ORAZ WYKONYWANIE ZAPYTAŃ SQL
$mysqli = new mysqli('localhost', 'root', '', 'test');

if($mysqli->connect_error) {
    die('Error');
} else {
    echo "";
}

// ZAPYTANIE SQL WYPISUJĄCE TOP 10 NAJCZĘSTSZYCH WYSTĄPIEŃ IMION WRAZ Z ICH LICZBĄ
$result = $mysqli->query("SELECT user_name,COUNT(*) AS liczba FROM usr GROUP BY user_name ORDER BY liczba DESC LIMIT 10");
// ZAPYTANIE SQL WYPISUJĄCE TOP 10 NAJCZĘSTSZYCH WYSTĄPIEŃ DAT WRAZ Z ICH LICZBĄ (od 2000-01-01)
$result1 = $mysqli->query("SELECT user_date,COUNT(*) AS liczba FROM usr WHERE user_date >='2000-01-01' GROUP BY user_date ORDER BY liczba DESC LIMIT 10");

// WYPISYWANIE DANYCH W UWTORZONYCH TABLICACH
print '<h2> TOP 10 najczęstszych imion </h2>';
print '<table border="1">';

while($row=$result->fetch_assoc()) {
    print '<tr>';
    print '<td>'.$row['user_name'].'</td>';
    print '<td>'.$row['liczba'].'</td>';
    print '</tr>';
}
print '</table>';
print '</br>';
print '</br>';
print '<h2> TOP 10 najczęstszych dat od 2000-01-01 </h2>';
print '<table border="1">';

while($row=$result1->fetch_assoc()) {
    print '<tr>';
    print '<td>'.$row['user_date'].'</td>';
    print '<td>'.$row['liczba'].'</td>';
    print '</tr>';
}
print '</table>';

?>


