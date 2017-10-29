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


class FileSongRepository implements ISongRepository
{
    private $fileName = 'data/data.txt';

    public function saveSong($song)
    {
        $dataArray = $this->getAllSongs();
        $dataArray[$song->getId()] = $song;
        $serialData = serialize($dataArray);
        file_put_contents($this->fileName, $serialData);
    }

    public function getAllSongs()
    {
        $data = file_get_contents($this->fileName);
        if ($data) {
            $dataArray = unserialize($data);
            return $dataArray;
        } else {
            return array();
        }
    }

    public function getSongById($id)
    {
        $songList = $this->getAllSongs();
        if (array_key_exists($id, $songList)) {
            return $songList[$id];
        }
    }

    public function deleteSong($songId)
    {
        $songList = $this->getAllSongs();
        if (array_key_exists($songId, $songList)) {
            unset($songList[$songId]);
            $serialData = serialize($songList);
            file_put_contents($this->fileName, $serialData);
        }
    }

}