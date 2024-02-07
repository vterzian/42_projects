/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_printunsigned.c                                 :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 19:25:07 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 19:40:24 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

int	ft_printunsigned(va_list ap)
{
	char 			*p;
	unsigned int	x;

	x = va_arg(ap, unsigned int);
	p = ft_utoa(x);
	ft_putstr(p);
	return (ft_strlen(p));
}
