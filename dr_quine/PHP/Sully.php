#!/usr/bin/user
<?php

function main()
{
	$i = 5;
	if ($i <= 0)
		return (0);
	if (@fopen('Sully_'.$i.'.php', 'r') != false)
		$i--;
	$str = '#!/usr/bin/user%1$c<?php%1$c%1$cfunction main()%1$c{%1$c	$i = %4$d;%1$c	if ($i <= 0)%1$c		return (0);%1$c	if (@fopen(%2$cSully_%2$c.$i.%2$c.php%2$c, %2$cr%2$c) != false)%1$c		$i--;%1$c	$str = %2$c%3$s%2$c;%1$c	$file = @fopen(%2$cSully_%2$c.$i.%2$c.php%2$c, %2$cw%2$c) or die("Can%2$ct create file");%1$c	fprintf($file, $str, 10, 39, $str, $i);%1$c	fclose($file);%1$c	system(%2$cphp Sully_%2$c.$i.%2$c.php%2$c);%1$c	return (0);%1$c}%1$c%1$cmain();%1$c';
	$file = @fopen('Sully_'.$i.'.php', 'w') or die("Can't create file");
	fprintf($file, $str, 10, 39, $str, $i);
	fclose($file);
	system('php Sully_'.$i.'.php');
	return (0);
}

main();
