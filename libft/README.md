# Libft
## Table of Content
1. [Introduction](#introduction)
1. [Usage](#usage)
1. [Content](#content)
   * [Part1 - libc functions](#part1---libc-functions)
   * [Part2 - Additionnal functions](#part2---additionnal-functions)
   * [Part3 - Bonus](#part3---bonus)
  
## Introduction
First project at 42.

C programming can be very tedious when one doesn’t have access to those highly useful
standard functions. This project made me to take the time to re-write those functions,
understand them, and learn to use them. This library helped me for almost all my C
projects at 42.

## Usage 
Clone the repository, change directory to libft and execute the Makefile
```bash
   git clone https://github.com/Fendilin/libft.git
   cd libft
   make
```
This should produce a Library (libft.a) and some objects file.

To clean objects files use `clean` makefile rule
```bash
    make clean
```
To clean the library and objects files use `fclean` makefile rule
```bash
    make fclean
```

To clean all project an run it again use `re` makefile rule
```bash
   make re
```
## Content

### Part1 - Libc functions
In this first part, I had to re-code a set of the libc functions, as defined in their man.

* [memset](https://github.com/Fendilin/libft/blob/master/ft_memset.c)
* [bzero](https://github.com/Fendilin/libft/blob/master/ft_bzero.c)
* [memcpy](https://github.com/Fendilin/libft/blob/master/ft_memcpy.c)
* [memccpy](https://github.com/Fendilin/libft/blob/master/ft_memccpy.c)
* [memmove](https://github.com/Fendilin/libft/blob/master/ft_memmove.c)
* [memchr](https://github.com/Fendilin/libft/blob/master/ft_memchr.c)
* [memcmp](https://github.com/Fendilin/libft/blob/master/ft_memcmp.c)
* [strlen](https://github.com/Fendilin/libft/blob/master/ft_strlen.c)
* [strdup](https://github.com/Fendilin/libft/blob/master/ft_strdup.c)
* [strcpy](https://github.com/Fendilin/libft/blob/master/ft_strcpy.c)
* [strncpy](https://github.com/Fendilin/libft/blob/master/ft_strncpy.c)
* [strcat](https://github.com/Fendilin/libft/blob/master/ft_strcat.c)
* [strncat](https://github.com/Fendilin/libft/blob/master/ft_strncat.c)
* [strlcat](https://github.com/Fendilin/libft/blob/master/ft_strlcat.c)
* [strchr](https://github.com/Fendilin/libft/blob/master/ft_strchr.c)
* [strrchr](https://github.com/Fendilin/libft/blob/master/ft_strrchr.c)
* [strstr](https://github.com/Fendilin/libft/blob/master/ft_strstr.c)
* [strnstr](https://github.com/Fendilin/libft/blob/master/ft_strnstr.c)
* [strcmp](https://github.com/Fendilin/libft/blob/master/ft_strcmp.c)
* [strncmp](https://github.com/Fendilin/libft/blob/master/ft_strncmp.c)
* [atoi](https://github.com/Fendilin/libft/blob/master/ft_atoi.c)
* [isalpha](https://github.com/Fendilin/libft/blob/master/ft_isalpha.c)
* [isdigit](https://github.com/Fendilin/libft/blob/master/ft_isdigit.c)
* [isalnum](https://github.com/Fendilin/libft/blob/master/ft_isalnum.c)
* [isascii](https://github.com/Fendilin/libft/blob/master/ft_isascii.c)
* [isprint](https://github.com/Fendilin/libft/blob/master/ft_isprint.c)
* [toupper](https://github.com/Fendilin/libft/blob/master/ft_toupper.c)
* [tolower](https://github.com/Fendilin/libft/blob/master/ft_tolower.c)

### Part2 - Additionnal functions
In this second part, I had to code a set of functions that are either not included in the
libc, or included in a different form.

| Name                                                                         | Prototype                                                       | Description                                                                                                                                              | Param #1                             | Param #2                 | Param #3            | Return                                                      |
|------------------------------------------------------------------------------|-----------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------|--------------------------|---------------------|-------------------------------------------------------------|
|[ft_memalloc](https://github.com/Fendilin/libft/blob/master/ft_memalloc.c)    | void * ft_memalloc(size_t size);                                | Returns a “fresh” memory area. The memory allocated is initialized to 0.                                                                                 | Size of the allocation               | NULL                     | NULL                | Allocated memory area                                       |
|[ft_memdel](https://github.com/Fendilin/libft/blob/master/ft_memdel.c)        | void ft_memdel(void **ap);                                      | Free the adress of memory area given as parameter, then puts pointer to NULL.                                                                            | Pointer to free                      | NULL                     | NULL                | NULL                                                        |
|[ft_strnew](https://github.com/Fendilin/libft/blob/master/ft_strnew.c)        | char * ft_strnew(size_t size);                                  | Returns a “fresh” string ending with ’\0’. Each character of the string is initialized at ’\0’.                                                          | Size of allocation                   | NULL                     | NULL                | String allocated and initialized to 0                       |
|[ft_strdel](https://github.com/Fendilin/libft/blob/master/ft_strdel.c)        | void ft_strdel(char **as);                                      | Free the adress of a string given as parameter, then set is pointer to NULL                                                                              | String adress                        | NULL                     | NULL                | NULL                                                        |
|[ft_strclr](https://github.com/Fendilin/libft/blob/master/ft_strclr.c)        | void ft_strclr(char *s);                                        | Sets every character of the string to the value ’\0’.                                                                                                    | String to be cleard                  | NULL                     | NULL                | NULL                                                        |
|[ft_striter](https://github.com/Fendilin/libft/blob/master/ft_striter.c)      | void ft_striter(char *s, void (*f)(char *));                    | Applies the function f to each character of the string passed as argument.                                                                               | String to iterate                    | Function to apply        | NULL                | NULL                                                        |
|[ft_striteri](https://github.com/Fendilin/libft/blob/master/ft_striteri.c)    | void ft_striteri(char *s, void (*f)(unsigned int, char *));     | Applies the function f to each character of the string passed as argument. And passing it index as first argument                                        | String to iterate                    | Function to apply        | NULL                | NULL                                                        |
|[ft_strmap](https://github.com/Fendilin/libft/blob/master/ft_strmap.c)        | char * ft_strmap(char const *s, char (*f)(char));               | Applies the function f to each character of the string given as argument to create a “fresh” new string resulting from the successive applications of f. | String to map                        | Function to apply        | NULL                | "Fresh" string create from application of f                 |
|[ft_strmapi](https://github.com/Fendilin/libft/blob/master/ft_strmapi.c)      | char * ft_strmapi(char const *s, char (*f)(unsigned int, char));| Applies the function f to each character of the string given as argument to create a “fresh” new string resulting from the successive applications of f. | String to map                        | Function to apply        | NULL                | "Fresh" string create from application of f                 |
|[ft_strequ](https://github.com/Fendilin/libft/blob/master/ft_strequ.c)        | int ft_strequ(char const *s1, char const *s2);                  | Lexicographical comparison between s1 and s2. If the 2 strings are identical the function returns 1, or 0 otherwise.                                     | Frist string to compare              | Second string to compare | NULL                | 1 or 0 if the 2 strings ar identical or not                 |
|[ft_strnequ](https://github.com/Fendilin/libft/blob/master/ft_strnequ.c)      | int ft_strnequ(char const *s1, char const *s2, size_t n);       | Lexicographical comparison between s1 and s2 up to n characters or until a ’\0’ is reached. If the 2 strings are identical, the function returns 1, or 0.| Frist string to compare              | Second string to compare | Max char to compare | 1 or 0 if the 2 strings ar identical or not                 |
|[ft_strsub](https://github.com/Fendilin/libft/blob/master/ft_strsub.c)        | char * ft_strsub(char const *s, unsigned int start, size_t len);| Returns a “fresh” substring from the string given as argument. The substring begins at indexstart and is of size len.                                    | String from wich create the substring| Start index              | Size of substring   | The substring                                               |
|[ft_strjoin](https://github.com/Fendilin/libft/blob/master/ft_strjoin.c)      | char * ft_strjoin(char const *s1, char const *s2);              | Returns a “fresh” string ending with ’\0’, result of the concatenation of s1 and s2.                                                                     | Prefix string                        | Suffix string            | NULL                | “Fresh” string result of the concatenation of the 2 strings.|
|[ft_strtrim](https://github.com/Fendilin/libft/blob/master/ft_strtrim.c)      | char * ft_strtrim(char const *s);                               | Returns a copy of the string given as argument without whitespaces at the beginning or at the end of the string.                                         | String to be trimed                  | NULL                     | NULL                | the "fresh" trimmed or a copy of s                          |
|[ft_strplit](https://github.com/Fendilin/libft/blob/master/ft_strsplit.c)     | char ** ft_strsplit(char const *s, char c);                     | Returns an array of “fresh” strings (all ending with ’\0’, including the array itself) obtained by spliting s using the character c as a delimiter.      | String to split                      | Delimiter character      | NULL                | The array of "fresh" strings result of split                |
|[ft_itoa](https://github.com/Fendilin/libft/blob/master/ft_itoa.c)            | char * ft_itoa(int n);                                          | returns a “fresh” string ending with ’\0’ representing the integer n given as argument. Negative numbers must be supported.                              | Integer to be tranformed into string | NULL                     | NULL                | The string representing the integer passed as argument.     |
|[ft_putchar](https://github.com/Fendilin/libft/blob/master/ft_putchar.c)      | void ft_putchar(char c);                                        | Outputs the character c to the standard output.                                                                                                          | The character to output.             | NULL                     | NULL                | NULL                                                        |
|[ft_putstr](https://github.com/Fendilin/libft/blob/master/ft_putstr.c)        | void ft_putstr(char const *s);                                  | Outputs the string s to the standard output.                                                                                                             | The string to output.                | NULL                     | NULL                | NULL                                                        |
|[ft_putendl](https://github.com/Fendilin/libft/blob/master/ft_putendl.c)      | void ft_putendl(char const *s);                                 | Outputs the string s to the standard output followed by a ’\n’.                                                                                          | The string to output.                | NULL                     | NULL                | NULL                                                        |
|[ft_putnbr](https://github.com/Fendilin/libft/blob/master/ft_putnbr.c)        | void ft_putnbr(int n);                                          | Outputs the integer n to the standard output.                                                                                                            | The integer to output.               | NULL                     | NULL                | NULL                                                        |
|[ft_putchar_fd](https://github.com/Fendilin/libft/blob/master/ft_putchar_fd.c)| void ft_putchar_fd(char c, int fd);                             | Outputs the char c to the file descriptor fd.                                                                                                            | The character to output.             | The file descriptor      | NULL                | NULL                                                        |
|[ft_putstr_fd](https://github.com/Fendilin/libft/blob/master/ft_putstr_fd.c)  | void ft_putstr_fd(char const *s, int fd);                       | Outputs the string s to the file descriptor fd.                                                                                                          | The string to output.                | The file descriptor      | NULL                | NULL                                                        |
|[ft_putendl_fd](https://github.com/Fendilin/libft/blob/master/ft_putendl_fd.c)| void ft_putendl_fd(char const *s, int fd);                      | Outputs the string s to the file descriptor fd followed by a ’\n’.                                                                                       | The string to output.                | The file descriptor      | NULL                | NULL                                                        |
|[ft_putnbr_fd](https://github.com/Fendilin/libft/blob/master/ft_putnbr_fd.c)  | void ft_putnbr_fd(int n, int fd);                               | Outputs the integer n to the file descriptor fd.                                                                                                         | The integer to print.                | The file descriptor      | NULL                | NULL                                                        |

### Part3 - Bonus

I had to create function wich allow me to manipuate my lists more easilly.

| Name                                                                         | Prototype                                                       | Description                                                                                                                                              | Param #1                                                                     | Param #2                                                   | Return        |
|------------------------------------------------------------------------------|-----------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------|------------------------------------------------------------|---------------|
|[ft_lstnew](https://github.com/Fendilin/libft/blob/master/ft_lstnew.c)        | t_list * ft_lstnew(void const *content, size_t content_size);   | Allocate and return a "fresh" link.                                                                                                                      | The content to put in the new link.                                          | The size of the content of the new link.                   | The new link. |
|[ft_lstdelone](https://github.com/Fendilin/libft/blob/master/ft_lstdelone.c)  | void ft_lstdelone(t_list **alst, void (*del)(void *, size_t));  | Free memory of the link's pointer given as parameter.                                                                                                    | The adress of a pointer to a link that needs to be freed.                    | NULL                                                       | NULL          |
|[ft_lstdel](https://github.com/Fendilin/libft/blob/master/ft_lstdel.c)        | void ft_lstdel(t_list **alst, void (*del)(void *, size_t));     | Free memory of the link's pointer and every successor of that link.                                                                                      | The address of a pointer to the first link of a list that needs to be freed. | NULL                                                       | NULL          |
|[ft_lstadd](https://github.com/Fendilin/libft/blob/master/ft_lstadd.c)        | void ft_lstadd(t_list **alst, t_list *new);                     | Adds the element new at the beginning of the list.                                                                                                       | The address of a pointer to the first link of a list.                        | The link to add at the beginning of the list.              | NULL          |
|[ft_lstiter](https://github.com/Fendilin/libft/blob/master/ft_lstiter.c)      | void ft_lstiter(t_list *lst, void (*f)(t_list *elem));          | Iterates the list lst and applies the function f to each link.                                                                                           | A pointer to the first link of a list.                                       | The address of a function to apply to each link of a list. | NULL          |

