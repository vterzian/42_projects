#!/usr/bin/php
<?php

const FILE = 'Grace_kid.php';

function printInFile($file, $str)
{
	fprintf($file, $str, 10, 39, $str) or die("Can't create file");
	return (0);
}

function main()
{
	if (($file = @fopen(FILE, 'w+')) == FALSE)
		return (0);
	$str = '#!/usr/bin/php%1$c<?php%1$c%1$cconst FILE = %2$cGrace_kid.php%2$c;%1$c%1$cfunction printInFile($file, $str)%1$c{%1$c	fprintf($file, $str, 10, 39, $str) or die("Can%2$ct create file");%1$c	return (0);%1$c}%1$c%1$cfunction main()%1$c{%1$c	if (($file = @fopen(FILE, %2$cw+%2$c)) == FALSE)%1$c		return (0);%1$c	$str = %2$c%3$s%2$c;%1$c	printInFile($file, $str);%1$c	fclose($file);%1$c	return (0);%1$c}%1$c%1$cmain();%1$c';
	printInFile($file, $str);
	fclose($file);
	return (0);
}

main();
