<?php
/**
 * Created by PhpStorm.
 * User: briantbailey
 * Date: 9/30/15
 * Time: 7:17 PM
 */
require_once 'MySQLSongRepository.php';
require_once 'Song.php';

//$songRepo = new \bbailey4\class6\FileSongRepository();
$songRepo = new \bbailey4\class6\MySQLSongRepository();

$songList = $songRepo->getAllSongs();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SongList</title>
</head>
<body>
<p><a href="create.php">Add New Song</a></p>
<h1>All Songs</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Song Title</th>
        <th>Song Rating</th>
    </tr>
    <?php
    foreach($songList as $song) {
        print '<tr>';
        print '<td>' . $song->getId() . '</td>';
        print '<td><a href="show.php?id=' . $song->getId() . '">'. $song->getTitle() .'</a></td>';
        print '<td>' . $song->getRating() . '</td>';
        print '</tr>';
    }
    ?>
</table>
<?php //print_r($songList); ?>
</body>
</html>
