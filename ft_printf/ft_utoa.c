/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_utoa.c                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 19:27:58 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 20:07:25 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

char *ft_utoa(unsigned int n)
{
	char			*p;
	unsigned int	x;
	int				i;

	i = 0;
	x = n;
	while (x >= 10)
	{
		x /= 10;
		i++;
	}
	p = (char*)malloc(sizeof(p) * i + 1);
	if (p)
	{
		p[i + 1] = '\0';
		while (i >= 0)
		{
			x = n % 10;
			p[i] = 48 + x;
			n = n / 10;
			i--;
		}
	}
	return (p);
}
