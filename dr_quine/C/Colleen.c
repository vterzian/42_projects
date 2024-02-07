#include <stdio.h>

/*
	One comment, one !
*/

void print_src (char *str)
{
	printf(str, 10, 9, str, 34);
}

int main (void)
{
	/*
		A second comment, for real ?
	*/
	char *str = "#include <stdio.h>%1$c%1$c/*%1$c%2$cOne comment, one !%1$c*/%1$c%1$cvoid print_src (char *str)%1$c{%1$c%2$cprintf(str, 10, 9, str, 34);%1$c}%1$c%1$cint main (void)%1$c{%1$c%2$c/*%1$c%2$c%2$cA second comment, for real ?%1$c%2$c*/%1$c%2$cchar *str = %4$c%3$s%4$c;%1$c%1$c%2$cprint_src(str);%1$c%1$c%2$creturn (0);%1$c}%1$c";

	print_src(str);

	return (0);
}
