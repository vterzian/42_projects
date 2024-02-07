/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_printf.h                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/16 11:20:19 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 22:27:58 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#ifndef FT_PRINTF_H
# define FT_PRINT_H

# include "libft.h"
# include <string.h>
# include <stdarg.h>

int		ft_printf(const char *format, ...);
char	*ft_otoa(unsigned int n);
char	*ft_htoa(unsigned long n);
char	*ft_utoa(unsigned int n);
int		ft_printchar(va_list ap);
int		ft_printstr(va_list ap);
int		ft_printnbr(va_list ap);
int		ft_printoctal(va_list ap);
int		ft_printhexa(va_list ap);
int		ft_printunsigned(va_list ap);
int		ft_printptr(va_list ap);

#endif
