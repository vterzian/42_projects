/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   libftasm.h                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/04/17 16:08:32 by vterzian          #+#    #+#             */
/*   Updated: 2015/04/28 19:51:33 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#ifndef LIBFTASM_H
# define LIBFTASM_H

# include <string.h>
# include <stdlib.h>
# include <stdio.h>

void	ft_bzero(void *s, size_t n);
int		ft_isalpha(int c);
int		ft_isdigit(int c);
int		ft_isalnum(int c);
int		ft_isascii(int c);
int		ft_isprint(int c);
int		ft_islower(int c);
int		ft_isupper(int c);
int		ft_isspace(int c);
int		ft_tolower(int c);
int		ft_toupper(int c);
char	*ft_strcat(char *s1, const char *s2);
char	*ft_strdup(const char *s1);
void	*ft_memcpy(void	*dst, const void *src, size_t n);
void	*ft_memset(void *b, int c, size_t len);
void	*ft_memalloc(size_t size);
size_t	ft_strlen(const char *s);
int		ft_puts(const char *s);
void	ft_cat(int fd);
char 	*ft_strncat(char *s1, const char *s2, size_t n);

#endif
