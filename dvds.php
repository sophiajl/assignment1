<style>
    td {
        padding: 5px;
        border: 1px solid #CCC;
    }
</style>

<?php

if (!isset($_GET['title'])) {
    header('Location: index.php');
}

$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username = 'student';
$password = 'ttrojan';

$title = $_GET['title'];

$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

$sql = "
  SELECT title, genre_name, format_name, rating_name
  FROM dvds
  INNER JOIN genres
  ON dvds.genre_id = genres.id
  INNER JOIN formats
  ON dvds.format_id = formats.id
  INNER JOIN ratings
  ON dvds.rating_id = ratings.id
  WHERE dvds.title LIKE ?
";

$statement = $pdo->prepare($sql);
$like = '%'.$title.'%';
$statement->bindParam(1, $like);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

$rows = $statement->rowCount();

echo "You searched for" . " '$title'" . ":";
echo "</br>";
if($rows == 0){
    echo "Sorry, no results were found. Go back to "; ?><a href="index.php">search</a>

    <?php
}

else{
?>


    <table>
        <tr>
            <th>Dvd Title</th>
            <th>Genre</th>
            <th>Format</th>
            <th>Rating</th>
            <th>More</th>
        </tr>

        <?php foreach($dvds as $dvd) : ?>
        <tr>
            <td> <?php echo $dvd->title ?> </td>
            <td> <?php echo $dvd->genre_name ?> </td>
            <td> <?php echo $dvd->format_name ?></td>
            <td> <?php echo $dvd->rating_name ?></td>
            <td> <a href="ratings.php?rating=<?php echo $dvd->rating_name ?>"> View other <?php echo $dvd->rating_name?> rated movies</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php }; ?>