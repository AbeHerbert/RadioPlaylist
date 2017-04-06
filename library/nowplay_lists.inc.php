<?php

class Lists extends NowPlaying {


   public function nowPlaying() {
      $last = $this->db->query("SELECT song_id FROM playlist_history ORDER BY id DESC LIMIT 1");
      $info = $last->fetch_assoc();
      $return = $this->songInfo($info['song_id']);
      return $return;
   }

   public function lastPlayed($start=1,$limit=10) {
      $return = [];
      $plays = $this->db->query("SELECT SQL_CALC_FOUND_ROWS song_id, timestamp FROM playlist_history ORDER BY timestamp DESC LIMIT $start, $limit");
      $playlist = $plays->fetch_all(MYSQLI_ASSOC);

            $getCount = $this->db->query("SELECT FOUND_ROWS() as count");
            $return['count'] = $getCount->fetch_assoc()['count'];

      $songs = [];

      foreach($playlist as $p) {
         $ret = [];
         $ret = $this->songInfo($p['song_id']);
         $ret['timestamp'] = $p['timestamp'];
         $songs[] = $ret;
      }

      $return['songs'] = $songs;

      return $return;
   }

   public function archiveView($date,$start=0,$limit=10) {
      $return = [];
      $plays = $this->db->query("SELECT SQL_CALC_FOUND_ROWS song_id, timestamp FROM playlist_history WHERE DATE(timestamp) = '".date_format(date_create($date),'Y-m-d')."'  ORDER BY timestamp DESC LIMIT $start, $limit");
      $playlist = $plays->fetch_all(MYSQLI_ASSOC);

            $getCount = $this->db->query("SELECT FOUND_ROWS() as count");
            $return['count'] = $getCount->fetch_assoc()['count'];

      $songs = [];

      foreach($playlist as $p) {
         $ret = [];
         $ret['song'] = $this->songInfo($p['song_id']);
         $ret['timestamp'] = $p['timestamp'];
         $songs[] = $ret;
      }

      $return['songs'] = $songs;

      return $return;
   }

}
