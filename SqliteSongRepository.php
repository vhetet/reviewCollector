<?php
/**
 * Created by PhpStorm.
 * User: briantbailey
 * Date: 9/30/15
 * Time: 7:39 PM
 */

namespace bbailey4\class6;

require_once 'ISongRepository.php';
require_once 'Song.php';


class SqliteSongRepository implements ISongRepository
{
    private $dbfile = 'data/song_db_pdo.sqlite';
    private $db;

    public function __construct(){
        //open the database
        $this->db = new \PDO('sqlite:' . $this->dbfile);

        //create the table if not exists
        $this->db->exec("CREATE TABLE IF NOT EXISTS Songs (Id INTEGER PRIMARY KEY, Title TEXT, Rating TEXT)");
    }

    public function saveSong($song)
    {
        if ($song->getId() != '') {
            //Update
            $stmh = $this->db->prepare("UPDATE Songs SET Title = :title, Rating = :rating WHERE id = :id");
            $stmh->bindParam(':title', $song->getTitle());
            $stmh->bindParam(':rating', $song->getRating());
            $stmh->bindParam(':id', $song->getId());
            $stmh->execute();

        } else {
            //Insert
            $stmh = $this->db->prepare("insert into Songs (Title, Rating) values (:title, :rating)");
            $stmh->bindParam(':title', $song->getTitle());
            $stmh->bindParam(':rating', $song->getRating());
            $stmh->execute();

        }
    }

    public function getAllSongs()
    {
        $songlist = array();
        $result = $this->db->query('SELECT * FROM Songs');
        foreach($result as $row) {
            $aSong = new Song();
            $aSong->setTitle($row['Title']);
            $aSong->setRating($row['Rating']);
            $aSong->setId($row['Id']);
            $songlist[$aSong->getId()] = $aSong;
        }
        return $songlist;
    }

    public function getSongById($id)
    {
        $stmh = $this->db->prepare("SELECT * from Songs WHERE Id = :id");
        $sid = intval($id);
        $stmh->bindParam(':id', $sid);
        $stmh->execute();
        $stmh->setFetchMode(\PDO::FETCH_ASSOC);

        if ($row = $stmh->fetch()) {
            $aSong = new Song();
            $aSong->setId($row['Id']);
            $aSong->setTitle($row['Title']);
            $aSong->setRating($row['Rating']);
            return $aSong;
        } else {
            return new Song();
        }

//        $songList = $this->getAllSongs();
//        if (array_key_exists($id, $songList)) {
//            return $songList[$id];
//        }
    }

    public function deleteSong($songId)
    {
        // TODO: Implement deleteSong() method.
        $stmh = $this->db->prepare("DELETE FROM Songs WHERE id = :id");
        $stmh->bindParam(':id', intval($songId));
        $stmh->execute();
    }


}