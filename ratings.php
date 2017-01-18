<style>
    td {
        padding: 5px;
        border: 1px solid #CCC;
    }
</style>

<?php


$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username = 'student';
$password = 'ttrojan';

$rating = $_GET['rating'];

$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

$sql = "
  SELECT title, rating_name
  FROM dvds, ratings
  WHERE dvds.rating_id = ratings.id
  AND ratings.rating_name = ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

?>
<table>
    <tr>
        <th>Dvd Title</th>


    <?php foreach($dvds as $dvd) : ?>
        <tr>
            <td> <?php echo $dvd->title ?> </td>

        </tr>
    <?php endforeach; ?>
</table>



