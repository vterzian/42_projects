/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_printnbr.c                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/16 16:34:42 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/16 16:39:11 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

int	ft_printnbr(va_list ap)
{
	int		c;
	char	*p;

	c = va_arg(ap, int);
	p = ft_itoa(c);
	ft_putstr(p);
	return (ft_strlen(p));
}
