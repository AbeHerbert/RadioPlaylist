<?php

class Update extends NowPlaying {

   public function getLatest() {
      $content = simplexml_load_file('http://YOUR_XML_FILE_HERE/file.xml',"SimpleXMLElement",LIBXML_NOCDATA);
      // print_r($content);
      foreach($content->EventData as $event) {

         if($event->Event_Type == "MUSIC") {
            if($song = $this->lookup($event->Title,$event->Artist)) {
               $event = json_decode(json_encode($event),true);
               $this->addToHistory($song,$event);
               return $this->songInfo($song);
            } else {
               $ret = $this->getiTunesInfo($event);
               return $ret;
            }
         }
      }
   }


   public function getiTunesInfo($trackInfo) {
      $trackInfo = json_decode(json_encode($trackInfo),true);
      if(empty($trackInfo['Artist'])) { return false; }
      $searchTerm = str_replace(" ","+",$trackInfo['Title'].' '.$trackInfo['Artist']);
      $content = file_get_contents('https://itunes.apple.com/search?term='.$searchTerm.'&limit=1');
      $content = json_decode($content,true);
      if($content['resultCount'] === 1) {
         $content['results'][0]['Timestamp'] = $trackInfo['Timestamp'];
         $content['results'][0]['itunes'] = 1;
         $this->insertIntoTables($content['results'][0]);
         return $content['results'][0];
      } else {
         if($trackInfo['Album'] == "") { $trackInfo['Album'] = 'Unavailable'; }
         $trackInfo['itunes'] = 0;
         $this->insertIntoTables($trackInfo);
      }
   }


   private function insertIntoTables($info) {
      if($info['itunes'] == 0) {
         $this->processDataManual($info);
      } else {
         $this->processItunesData($info);
      }
   }



   private function processItunesData($info) {
      if(!$song = $this->lookup($info['trackName'],$info['artistName'],$info['trackId'])) {
         $song = $this->createRecords($info,$info['trackId']);
      }
      $this->addToHistory($song,$info);
   }


   private function processDataManual($info) {
      if(!$song = $this->lookup($info['Title'],$info['Artist'])) {
         $song = $this->createRecords($info);
      }
      $this->addToHistory($song,$info);
   }

   private function createArtist($artist) {
      $this->db->query("INSERT INTO playlist_artists (artist_name) VALUES ('".$this->db->escape_string($artist)."')");
   }

   private function createAlbum($album,$artist,$art=null) {
      $this->db->query("INSERT INTO playlist_albums (album_title,artist_id,album_art) VALUES ('".$this->db->escape_string($album)."','".$this->db->escape_string($artist)."','".$this->db->escape_string($art)."')");
   }

   private function createSong($artist,$album,$song,$trackId=null) {
      $this->db->query("INSERT INTO playlist_songs (song_name,artist_id,album_id,trackId) VALUES ('".$this->db->escape_string($song)."','".$this->db->escape_string($artist)."','".$this->db->escape_string($album)."','{$trackId}')");
   }

   private function createRecords($info,$itunes=null) {
      if($itunes != null) {

         $artist = $this->lookupArtist($info['artistName']);

         if(!$artist) {
            $this->createArtist($info['artistName']);
            $artist = $this->lookupArtist($info['artistName']);
         }

         $album = $this->lookupAlbum($info['collectionName'],$artist);

         if(!$album) {
            $this->createAlbum($info['collectionName'],$artist,$info['artworkUrl100']);
            $album = $this->lookupArtist($info['artistName']);
         }

         $song = $this->lookupSong($artist,$album,$info['trackName']);


         if(!$song) {
            $this->createSong($artist,$album,$info['trackName'],$info['trackId']);
            $song = $this->lookupSong($artist,$album,$info['trackName']);
         }


      } else {
         $artist = $this->lookupArtist($info['Artist']);

         if(!$artist) {
            $this->createArtist($info['Artist']);
            $artist = $this->lookupArtist($info['Artist']);
         }

         $album = $this->lookupAlbum($info['Album'],$artist);

         if(!$album) {
            $this->createAlbum($info['Album'],$artist,null);
            $album = $this->lookupAlbum($info['Album'],$artist);
         }

         $song = $this->lookupSong($artist,$album,$info['Title']);

         if(!$song) {
            $this->createSong($artist,$album,$info['Title']);
            $song = $this->lookupSong($artist,$album,$info['Title']);
         }

      }

      return $song;

   }

   private function addToHistory($song,$info) {
      $this->db->query("INSERT INTO playlist_history (song_id,rawtimestamp) VALUES ('{$song}','{$info['Timestamp']}')");
   }



}
