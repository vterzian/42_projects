/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   main.c                                             :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/04/17 16:34:17 by vterzian          #+#    #+#             */
/*   Updated: 2018/03/20 14:14:34 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "libftasm.h"
#include <stdio.h>
#include <fcntl.h>
#include <unistd.h>

void	ft_memalloc_test()
{
	ft_puts("\nFT_MEMALLOC_TEST");
	char *str;
	
	str = ft_memalloc(10);
	ft_memcpy(str, "salutsalu", 9);
	ft_puts(str);
}

void	ft_strncat_test()
{
	ft_puts("\nFT_STRNCAT_TEST");
	char *s1;
	char *s2;
	s1 = ft_strdup("salut");
	s2 = ft_strdup(" les amis");
	s2 = ft_strncat(s1, s2, 5);
	ft_puts(s1);	
}

void	ft_cat_test()
{
	ft_puts("\nFT_CAT TESTS");
	int fd;

	fd = open("ft_strlen.s" ,O_RDONLY);
	ft_cat(fd);
	ft_puts("\nentree standard: ");
	ft_cat(1);
	ft_cat(-1);
	close(fd);
}

void	ft_strlen_test()
{
	ft_puts("\nFT_STRLEN TESTS");

	int len;

	len = ft_strlen("salut");
	printf("salut 42	= %d\n", len);
	len = ft_strlen("123456789");
	printf("123456789	= %d\n", len);
	len = ft_strlen(NULL);
	printf("%d", len);
}

void	ft_strdup_test()
{
	char *s1;
	
	ft_puts("\nFT_STRDUP TESTS");
	s1 = ft_strdup("salut strdup!");
	ft_puts(s1);
	s1 = ft_strdup("kasjbfg;asbg;asbg;jbsdr;gjnasng");
	ft_puts(s1);
	s1 = ft_strdup(NULL);
	ft_puts(s1);
}

void	ft_strcat_test()
{
	ft_puts("\nFT_STRCAT TESTS");
	char *s1;
	char *s2;
	s1 = ft_strdup("salut");
	s2 = ft_strdup(" les amis");
	ft_strcat(s1, s2);
	ft_puts(s1);
	s1 = ft_strdup("salut");
	ft_bzero(s2, 10);
	ft_strcat(s1, s2);
	ft_puts(s1);
}

void	ft_puts_test()
{
	ft_puts("\nFT_PUTS_TESTS");
	ft_puts("SALUT $@(I()YTDNLSND");
}

void	ft_memset_test()
{
	ft_puts("\nFT_MEMSET TEST");
	char str[0xF00];

	ft_bzero(str, 0xF00);
	ft_memset(str, 'a', 42);
	ft_puts(str);
	ft_bzero(str, 0xF00);
	ft_memset(str, '1', 0);
	ft_puts(str);
}

void	ft_memcpy_test()
{
	ft_puts("\nFT_MEMCPY TEST");
	char s1[0xF00];
	char s2[] = "salut 42!";

	ft_memcpy(s1, s2, 5);
	ft_puts(s1);
	ft_bzero(s1, 0xF00);
	ft_memcpy(s1, s2, 0);
}

void	ft_toupper_test()
{
	char c;
	c = 'a';
	ft_puts("\nFT_TOUPPER TEST");
	c = ft_toupper(c);
	printf("'a' = %c \n", c);
	c = 'A';
	c = ft_toupper(c);
	printf("'A' = %c \n", c);
	c = '1';
	c = ft_toupper(c);
	printf("'1' = %c \n", c);
}

void	ft_tolower_test()
{
	char c;
	c = 'A';

	ft_puts("\nFT_TOLOWER TEST");
	c = ft_tolower(c);
	printf("'A' = %c\n", c);
	c = 'a';
	c = ft_tolower(c);
	printf("'a' = %c \n", c);
	c = '1';
	c = ft_tolower(c);
	printf("'1' = %c \n", c);

}

void	ft_isspace_test()
{
	char c;

	c = ' ';
	ft_puts("\nFT_ISSPACE TEST");
	printf("' ' = %d \n", ft_isspace(c));
	c = '\t';
	printf("'\\t' = %d \n", ft_isspace(c));
	c = '\v';
	printf("'\\v' = %d \n", ft_isspace(c));
	c = '\f';
	printf("'\\f' = %d \n", ft_isspace(c));
	c = '\r';
	printf("'\\r' = %d \n", ft_isspace(c));
	c = 'A';
	printf("'A' = %d \n", ft_isspace(c));
	c = '1';
	printf("'1' = %d \n", ft_isspace(c));
}

void	ft_isprint_test()
{
	char c;

	c = ' ';
	ft_puts("\nFT_ISPRINT TEST");
	printf("' ' = %d \n", ft_isprint(c));
	c = 'A';
	printf("'A' = %d \n", ft_isprint(c));
	c = '1';
	printf("'1' = %d \n", ft_isprint(c));

}

void	ft_isdigit_test()
{
	char c;

	c = '1';
	ft_puts("\nFT_ISDIGIT TEST");
	printf("'1' = %d \n", ft_isdigit(c));
	c = 'c';
	printf("'c' = %d \n", ft_isdigit(c));
	c = ' ';
	printf("' ' = %d \n", ft_isdigit(c));
}

void	ft_isascii_test()
{
	ft_puts("\nFT_ISASCII TEST");
	char c;
	c = ' ';
	printf("' ' = %d \n", ft_isascii(c));
	c = 'A';
	printf("'A' = %d \n", ft_isascii(c));
	c = 42;
	printf("'42' = %d \n", ft_isascii(c));

}

void	ft_isalpha_test()
{
	ft_puts("\nFT_ISALPHA TEST");
	char c;
	c = 'a';
	printf("'a' = %d \n", ft_isalpha(c));
	c = '1';
	printf("'1' = %d \n", ft_isalpha(c));
	c = ' ';
	printf("' ' = %d \n", ft_isalpha(c));
}

void	ft_isalnum_test()
{
	char c;
	ft_puts("\nFT_ISALNUM TEST");
	c = '1';
	printf("'1' = %d \n", ft_isalnum(c));
	c = 'a';
	printf("'a' = %d \n", ft_isalnum(c));
	c = ' ';
	printf("' ' = %d \n", ft_isalnum(c));
}

void	ft_bzero_test()
{
	ft_puts("\nFT_BZERO TESTS");

	char *str;
	str = ft_strdup("salut");
	ft_puts(str);
	ft_bzero(str, 5);
	ft_puts(str);
	ft_bzero(str, 0);
}


int	main(void)
{
	ft_bzero_test();
	ft_isalnum_test();
	ft_isalpha_test();
	ft_isascii_test();
	ft_isdigit_test();
	ft_isspace_test();
	ft_tolower_test();
	ft_toupper_test();
	ft_memcpy_test();
	ft_memset_test();
	ft_memalloc_test();
	ft_puts_test();
	ft_strcat_test();
	ft_strncat_test();
	ft_strdup_test();
	ft_strlen_test();
	ft_cat_test();
	return (0);
}
