<?php

require_once "library/nowplay_main.inc.php";
require_once "library/nowplay_update.inc.php";
require_once "library/nowplay_lists.inc.php";

$np = new Update;
$latest = $np->getLatest();

$playlist = new Lists;
$history = $playlist->lastPlayed(1,10);
?>

<html>
  <head>
    <title>Now Playing</title>
  </head>
  <body>
    <h2><?php echo $latest['trackName']; ?></h2>
    <div><strong>Album Name:</strong> <?php echo $latest['collectionName']; ?></div>
    <div><strong>Artist Name:</strong> <?php echo $latest['artistName']; ?></div>
    <img src="<?php echo $latest['artworkUrl100']; ?>">

    <hr>
    <table border="1" width="100%" cellspacing="0" bordercolor="#ccc" cellpadding="10">
      <tr><th>Art</th><th>Song Name</th><th>Album</th><th>Artist</th><th>Timestamp</th></tr>
    <?php foreach($history['songs'] as $track) {  ?>
      <tr>
      <td align="center"><img width="100" src="<?php echo $track['artworkUrl100']; ?>"></td>
      <td><?php echo $track['trackName']; ?></td>
      <td><?php echo $track['collectionName']; ?></td>
      <td><?php echo $track['artistName']; ?></td>
      <td><?php echo $track['timestamp']; ?></td>
    <?php } ?>
  </table>
  </body>
</html>
