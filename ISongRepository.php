<?php
/**
 * Created by PhpStorm.
 * User: briantbailey
 * Date: 9/30/15
 * Time: 7:37 PM
 */

namespace bbailey4\class6;


interface ISongRepository
{
    public function saveSong($song);
    public function getAllSongs();
    public function getSongById($id);
    public function deleteSong($songId);
}