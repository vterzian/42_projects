/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_printptr.c                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 19:42:28 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 19:46:37 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

int	ft_printptr(va_list ap)
{
	char	*p;
	unsigned long x;
	
	ft_putstr("0x");
	x = va_arg(ap, unsigned long);
	p = ft_htoa(x);
	ft_putstr(p);
	return (ft_strlen(p) + 2);
}
