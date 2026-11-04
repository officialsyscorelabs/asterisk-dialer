<?php
$output = shell_exec('sh count-channels.sh');
echo "Authroization Checked";
echo "<pre>$output</pre>";
?>