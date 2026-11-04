<?php
$output = shell_exec('sh show-channels.sh');
echo "Authroization Checked";
echo "<pre>$output</pre>";
?>