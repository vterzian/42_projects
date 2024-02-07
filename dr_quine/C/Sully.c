#include <fcntl.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int main(void)
{
	FILE	*f;
	char	buff[0xfff];
	int		i;
	i = 5;

	if (open("Sully_0.c", O_RDWR) != -1)
		return (0);
	if (i < 0)
		return (1);
	sprintf(buff, "Sully_%d.c", i);
	if (open(buff, O_RDWR) != -1)
		i--;

	char *str = "#include <fcntl.h>%1$c#include <stdio.h>%1$c#include <string.h>%1$c#include <stdlib.h>%1$c%1$cint main(void)%1$c{%1$c%2$cFILE%2$c*f;%1$c%2$cchar%2$cbuff[0xfff];%1$c%2$cint%2$c%2$ci;%1$c%2$ci = %6$d;%1$c%1$c%2$cif (open(%3$cSully_0.c%3$c, O_RDWR) != -1)%1$c%2$c%2$creturn (0);%1$c%2$cif (i < 0)%1$c%2$c%2$creturn (1);%1$c%2$csprintf(buff, %3$cSully_%%d.c%3$c, i);%1$c%2$cif (open(buff, O_RDWR) != -1)%1$c%2$c%2$ci--;%1$c%1$c%2$cchar *str = %3$c%5$s%3$c;%1$c%2$csprintf(buff, %3$cSully_%4$cd.c%3$c, i);%1$c%2$cf = fopen(buff, %3$cw%3$c);%1$c%2$cif (f == NULL)%1$c%2$c%2$creturn (0);%1$c%2$cfprintf(f, str, 10, 9, 34, 37, str, i);%1$c%2$cfclose(f);%1$c%2$csprintf(buff, %3$cgcc Sully_%4$c1$d.c -o Sully_%4$c1$d; ./Sully_%4$c1$d%3$c, i);%1$c%2$csystem(buff);%1$c%1$c%2$creturn (0);%1$c}%1$c";
	sprintf(buff, "Sully_%d.c", i);
	f = fopen(buff, "w");
	if (f == NULL)
		return (0);
	fprintf(f, str, 10, 9, 34, 37, str, i);
	fclose(f);
	sprintf(buff, "gcc Sully_%1$d.c -o Sully_%1$d; ./Sully_%1$d", i);
	system(buff);

	return (0);
}
