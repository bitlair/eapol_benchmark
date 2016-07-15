<?php
include("config.php");

foreach ($connect_infos as $connect_info) {
	foreach ($eapol_configs as $eapol_config) {
		echo "Runtime = {$runtime} - threads = {$threads}\n";
		echo "Running with connect info = {$connect_info}, eapol config = {$eapol_config}\n";
		$a = array();
		for ($i = 0; $i < $threads; $i++) {
			$a[] = "{$php_binary_full_path} thread.php {$i} \"{$eapol_config}\" \"{$connect_info}\"";
		}
		$a = implode(" & ", $a);
		exec($a,$out);

		$success = 0;
		$failed = 0;

		foreach ($out as $line) {
			$t = explode(";",$line);
			$success += intval($t[1]);
			$failed += intval($t[2]);
		}

		echo "Success: {$success} " . ($success / $runtime) . "/s - Avg time for 1 query: " . ($runtime / ($success / $threads)) . "s \n";
		echo "Failed: {$failed} " . ($failed / $runtime) . "/s\n\n";
		unset($out);
	}
}
?>
