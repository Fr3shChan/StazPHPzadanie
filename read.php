<?php

$mysqli = new mysqli('localhost', 'root', '', 'test');

if($mysqli->connect_error) {
    die('Error');
} else {
    echo "";
}


$result = $mysqli->query("SELECT user_name,COUNT(*) AS liczba FROM usr GROUP BY user_name ORDER BY liczba DESC LIMIT 10");
$result1 = $mysqli->query("SELECT user_date,COUNT(*) AS liczba FROM usr WHERE user_date >='2000-01-01' GROUP BY user_date ORDER BY liczba DESC LIMIT 10");

print '<h2> TOP 10 najczęstszych imion </h2>';
print '<table border="1">';

while($row=$result->fetch_assoc()) {
    print '<tr>';
    //print '<td>'.$row['user_id'].'</td>';
    print '<td>'.$row['user_name'].'</td>';
    //print '<td>'.$row['user_date'].'</td>';
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
    //print '<td>'.$row['user_id'].'</td>';
    //print '<td>'.$row['user_name'].'</td>';
    print '<td>'.$row['user_date'].'</td>';
    print '<td>'.$row['liczba'].'</td>';
    print '</tr>';

}

print '</table>';

?>

