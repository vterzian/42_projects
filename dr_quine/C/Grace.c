#include <stdio.h>

/*
	One comment, one !
*/

#define A(a) void F_A() {}
#define B(b) void F_B() {}

#define FT(x) int main(void) {FILE *f = fopen("Grace_kid.c", "w"); if (f == NULL) return (1);char *str = "#include <stdio.h>%1$c%1$c/*%1$c%2$cOne comment, one !%1$c*/%1$c%1$c#define A(a) void F_A() {}%1$c#define B(b) void F_B() {}%1$c%1$c#define FT(x) int main(void) {FILE *f = fopen(%3$cGrace_kid.c%3$c, %3$cw%3$c);if (f == NULL) return (1);char *str = %3$c%4$s%3$c;fprintf(f, str, 10, 9, 34, str);fclose(f);return (0);}%1$cFT()%1$c";fprintf(f, str, 10, 9, 34, str);fclose(f);return (0);}
FT()
