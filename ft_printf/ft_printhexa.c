/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_printhexa.c                                     :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 18:32:28 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 18:44:15 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

int	ft_printhexa(va_list ap)
{
	char 			*p;
	unsigned int	x;

	x = va_arg(ap, unsigned int);
	p = ft_htoa(x);
	ft_putstr(p);	
	return (ft_strlen(p));
}
