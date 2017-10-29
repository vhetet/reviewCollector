<?php
/**
 * Created by PhpStorm.
 * User: briantbailey
 * Date: 9/30/15
 * Time: 8:14 PM
 */

require_once 'MySQLSongRepository.php';
require_once 'Song.php';

$songRepo = new \bbailey4\class6\MySQLSongRepository();

//Shortend Get variable names if set
$songId = isset($_GET['id']) ? $_GET['id'] : '';

$song = $songRepo->getSongById($songId);

?>

<?php if ($song): ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Song <?php print $song->getTitle(); ?></title>
</head>
<body>
<p>Song Title: <?php print $song->getTitle();?></p>
<p>Song Rating: <?php print $song->getRating();?></p>
<p>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php print $song->getId();?>">
        <input type="submit" value="Edit Song">
    </form>
</p>
<p>
    <form action="delete.php" method="POST">
        <input type="hidden" name="id" value="<?php print $song->getId();?>">
        <input type="submit" value="Delete Song">
    </form>
</p>
</body>
</html>
<?php else: ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>No Song To Show</title>
</head>
<body>
<h1>No Song Found</h1>
  <a href="index.php">Back to Song List</a>
</body>
</html>
<?php endif; ?>
