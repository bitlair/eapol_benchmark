<?php
include("config.php");
$success = 0;
$failed = 0;
$start = microtime(true);
$thread = $argv[1];
$config = $argv[2];
$connect_info = $argv[3];

while (true) {
	exec("{$eapol_test_binary_full_path} -t {$radius_timeout} -c {$config} -s {$radius_secret} -a {$radius_server} -M {$mac} -C \"{$connect_info}\"",$out);
	$last = $out[count($out)-1];
	if ($last == "SUCCESS") $success++;
	else $failed++;
	unset($out);

	$t = microtime(true) - $start;
	//echo "[$thread] [$t] {$mac} -- {$last} -- Success: {$success} " . ($success / $t) . "/s -- Failed: {$failed}\n";

	if ($t >= $runtime) {
		echo "{$thread};{$success};{$failed}\n";
		break;
	}
}
