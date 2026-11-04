<?php
$output = shell_exec('sh show-peers.sh');
echo "Authroization Checked";
echo "<pre>$output</pre>";
?>