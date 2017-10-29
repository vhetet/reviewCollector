<?php
/**
 * Created by PhpStorm.
 * User: briantbailey
 * Date: 9/30/15
 * Time: 7:25 PM
 */

require_once 'Song.php';
require_once 'MySQLSongRepository.php';

//Shortend Post variable names if set
$songTitle = isset($_POST['title']) ? trim($_POST['title']) : '';
$songRating = isset($_POST['rating']) ? $_POST['rating'] : '';

//Validate form fields
$formIsValid = true;
$titleErr = '';
$ratingErr = '';
if (empty($songTitle)){
    $formIsValid = false;
    $titleErr = '<span style="color: #f00;">Title is required!</span>';
}
if (empty($songRating)){
    $formIsValid = false;
    $ratingErr = '<span style="color: #f00;">Title is required!</span>';
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Song</title>
</head>
<body>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <?php if ($formIsValid): ?>
        <?php
        $songRepo = new \bbailey4\class6\MySQLSongRepository();
        $song = new \bbailey4\class6\Song();
        $song->setTitle($songTitle);
        $song->setRating($songRating);
        $songRepo->saveSong($song);
        ?>
        <h1>New Song Created</h1>
        <p>Title: <?php print $songTitle; ?></p>
        <p>Rating: <?php print $songRating; ?></p>
        <p><a href="index.php">Show All Songs</a></p>
    <?php else: ?>
        <h1>Create New Song</h1>
        <form method="post" action="create.php">
            <label>Song Title: <input type="text" name="title" value="<?php print $songTitle; ?>"></label><?php print $titleErr; ?><br>
            <label>Song Rating: <select name="rating">
                    <?php
                    if (!empty($songRating)) {
                        for($i = 1; $i <= 5; $i++){
                            $selected = '';
                            if ($songRating == $i) {
                                $selected = 'selected';
                            }
                            print "<option $selected>$i</option>";
                        }
                    } else {
                        for($i = 1; $i <= 5; $i++){
                            print "<option>$i</option>";
                        }
                    }
                    ?>
                </select></label><?php print $ratingErr; ?><br>
            <input type="submit" value="Save Song">
        </form>
    <?php endif; ?>
<?php else: ?>
    <h1>Create New Song</h1>
    <form method="post" action="create.php">
        <label>Song Title: <input type="text" name="title"></label><br>
        <label>Song Rating: <select name="rating">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select></label><br>
        <input type="submit" value="Save Song">
    </form>
<?php endif; ?>
</body>
</html>
