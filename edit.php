<?php
/**
 * Created by PhpStorm.
 * User: briantbailey
 * Date: 9/30/15
 * Time: 8:33 PM
 */

require_once 'Song.php';
require_once 'MySQLSongRepository.php';

$songRepo = new \bbailey4\class6\MySQLSongRepository();

?>


<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id'])): ?>

    <?php
    // Came from show page based on id parameter
    $song = $songRepo->getSongById($_POST['id']);
     ?>
     <h1>Edit Song</h1>
        <form method="post" action="edit.php">
            <input type="hidden" name="songId" value="<?php print $_POST['id']; ?>">
            <label>Song Title: <input type="text" name="title" value="<?php print $song->getTitle(); ?>"></label><br>
            <label>Song Rating: <select name="rating">
                    <?php
                    $songRating = $song->getRating();
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
                </select></label><br>
            <input type="submit" value="Save Song">
        </form>

<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['songId'])): ?>

    <?php
    // Process edit form
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
    <?php if ($formIsValid): ?>
        <?php
        //Process valid data and save song update
        $aSong = $songRepo->getSongById($_POST['songId']);
        $aSong->setTitle($songTitle);
        $aSong->setRating($songRating);
        $songRepo->saveSong($aSong);
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Update Song</title>
        </head>
        <body>
        <h1>Song Updated</h1>
        <p><a href="index.php">Back to Song List</a></p>
        </body>
        </html>
    <?php else: ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Update Song</title>
        </head>
        <body>
        <h1>Edit Song</h1>
        <form method="post" action="edit.php">
            <input type="hidden" name="songId" value="<?php print $_POST['songId']; ?>">
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
        </body>
        </html>
    <?php endif; ?>

<?php else: ?>
    <!doctype html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Document</title>
    </head>
    <body>
      <h1>No Song Selected for Editing</h1>
      <p><a href="index.php">Back to Song List</a></p>
    </body>
    </html>
<?php endif;?>