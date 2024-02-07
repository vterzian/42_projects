/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_htoa.c                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 17:55:42 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 19:24:54 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

static int	get_hexa_value(int x)
{
	if (x >= 0 && x <= 9)
		return (48 + x);
	else if (x >= 10 && x <= 15)
	{
		x -= 10;
		return (97 + x);
	}
	return (0);
}

char		*ft_htoa(unsigned long n)
{
	char		*p;
	int			i;
	unsigned long x;

	i = 0;
	x = n;
	while (x > 15)
	{
		x = x / 16;
		i++;
	}
	p = (char*)malloc(sizeof(char*) * i + 1);
	if (p)
	{
		p[i + 1] = '\0';
		while (i >= 0)
		{
			x = n % 16;
			p[i] = get_hexa_value(x);
			n = n / 16;
			i--;
		}
	}
	return (p);
}
