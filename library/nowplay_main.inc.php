<?php

class NowPlaying {

   public $db;
   public $noart = 'data:image/png;base64,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';

   public function __construct() {
      $this->db = new mysqli('localhost','user','password','database');
   }

   public function lookup($song,$artist,$itunes=null) {
         if($itunes === null) {
            $getSongs = $this->db->query("SELECT * FROM playlist_songs RIGHT JOIN playlist_artists USING (artist_id) WHERE song_name = '".$this->db->escape_string($song)."' AND artist_name = '".$this->db->escape_string($artist)."'");
         } else {
            $getSongs = $this->db->query("SELECT * FROM playlist_songs RIGHT JOIN playlist_artists USING (artist_id) WHERE song_name = '".$this->db->escape_string($song)."' AND artist_name = '".$this->db->escape_string($artist)."' AND trackId = '{$itunes}'");
         }
         if($result = $getSongs->fetch_assoc()) {
            return $result['song_id'];
         } else {
            return false;
         }
   }


   /**
    * Gets all song information
    * @param  int   $song   The song id
    * @return array
    */
   public function songInfo($song) {
      $search = $this->db->query("SELECT song_name as trackName, IFNULL(album_title,'Unavailable') as collectionName, artist_name as artistName, IFNULL(album_art,'".$this->noart."') as artworkUrl100, playlist_songs.song_id FROM playlist_songs LEFT JOIN playlist_albums USING (album_id) LEFT JOIN playlist_artists ON playlist_songs.artist_id = playlist_artists.artist_id WHERE song_id = '{$song}'") or die($this->db->error);
      if($r = $search->fetch_assoc()) {
            if($r['artworkUrl100'] == "") {
              $r['artworkUrl100'] = $this->noart;
            }
            return $r;
      } else {
            return false;
      }
   }

   /**
    * Lookup the song by artist, album, and song.
    * @param  string $artist
    * @param  string $album
    * @param  string $song
    * @return int     returns the song id
    */
   public function lookupSong($artist,$album,$song) {
      $search = $this->db->query("SELECT * FROM playlist_songs WHERE artist_id = '".$this->db->escape_string($artist)."' AND album_id = '".$this->db->escape_string($album)."' AND song_name = '".$this->db->escape_string($song)."'");
      if($r = $search->fetch_assoc()) {
            return $r['song_id'];
      } else {
            return false;
      }
   }

   public function lookupArtist($artist) {
      $search = $this->db->query("SELECT * FROM playlist_artists WHERE artist_name = '".$this->db->escape_string($artist)."'");
      if($r = $search->fetch_assoc()) {
            return $r['artist_id'];
      } else {
            return false;
      }
   }

   public function lookupAlbum($album,$artistId) {
      $search = $this->db->query("SELECT * FROM playlist_albums WHERE artist_id = '".$this->db->escape_string($artistId)."' AND album_title = '".$this->db->escape_string($album)."'");
      if($r = $search->fetch_assoc()) {
         return $r['album_id'];
      } else {
         return false;
      }
   }

}
