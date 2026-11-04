<?php
$output = shell_exec('sh restart-switch.sh');
echo "Reloaded Successfully";
echo "<pre>$output</pre>";
?>