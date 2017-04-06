# RadioPlaylist

This software is designed to track XML playlists provided by radio station software to provide a playlist history. It pulls as much content as it can from iTunes API.

## How to get started

1. Clone the repo
2. Create the database & tables (see setup.sql)
3. Edit library/nowplay_main.inc.php with the correct database information.
4. Edit library/nowplay_update.inc.php with the correct address of your XML file. -- by this point, the script should run when you load it in your browser.
5. Create a cron to run every minute.
