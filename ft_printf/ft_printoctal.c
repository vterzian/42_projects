/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_printoctal.c                                    :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 17:12:28 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 18:42:29 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

int	ft_printoctal(va_list ap)
{
	unsigned int x;
	char 		*p;

	x = va_arg(ap, unsigned int);
	p = ft_otoa(x);
	ft_putstr(p);
	return (ft_strlen(p));
}
