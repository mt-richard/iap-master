<?php

class output
{
	public static function log($text, $filePath = "data/logs.txt", $mode = "a+")
	{
		$fh = fopen($filePath, $mode) or die("unable to create " . $filePath);
		fwrite($fh, $text) or die("Could not write to file");
		fclose($fh);
	}
	// to search string in word
	public static function isInString($search, $string): bool
	{
		$pos = strpos($string, $search);
		if ($pos === false) {
			return false;
		} else {
			return true;
		}
	}
	public static function readFile($filePath = "data/logs.txt", $mode = "r+")
	{
		if(!filesize($filePath)){
			return '';
		}
		$fh = fopen($filePath, $mode) or die("unable to create " . $filePath);
		$c=fgets($fh) or die("Could not read to file");
		fclose($fh);
		$c=trim($c);
		return strlen($c)>0?$c:''; 
	}
}
