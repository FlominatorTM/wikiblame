<?php
// We combine commands with '&&' to ensure we only pull if the directory change works
$command = "git pull 2>&1";

$output = shell_exec($command);

// 3. Display the result
echo "<h1>Git Pull Result</h1>";
echo "<pre>$output</pre>";
?>
