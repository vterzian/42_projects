#!/usr/bin/php
<?php

/*
	one comment, one!
*/

function print_src($str)
{
	printf($str, 10, 39, $str);
}

function main()
{
	/*
		A second comment, for real?
	*/
	$str = '#!/usr/bin/php%1$c<?php%1$c%1$c/*%1$c	one comment, one!%1$c*/%1$c%1$cfunction print_src($str)%1$c{%1$c	printf($str, 10, 39, $str);%1$c}%1$c%1$cfunction main()%1$c{%1$c	/*%1$c		A second comment, for real?%1$c	*/%1$c	$str = %2$c%3$s%2$c;%1$c	print_src($str);%1$c}%1$c%1$cmain();%1$c';
	print_src($str);
}

main();
