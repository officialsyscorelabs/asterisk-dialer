<?php
$my_file = 'reboot.server';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
$data = 'reboot requested';
fwrite($handle, $data);
echo "Processing Reboot Request....close your admin panel...TIMEOUT:60 secs";
?>