<?php

$startTs = microtime(true);

for($i = 0; $i < 5000000; $i++) {
	$n = $i;
}

echo $n;
echo "</br>";
echo "Time - ".(double)(microtime(true) - $startTs)." s";

echo phpinfo();

?>