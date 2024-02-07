/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_otoa.c                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/02/18 17:29:47 by vterzian          #+#    #+#             */
/*   Updated: 2015/02/18 18:41:10 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_printf.h"

char	*ft_otoa(unsigned int n)
{
	char			*p;
	int				i;
	unsigned int	x;

	i = 0;
	x = n;
	while (x > 7)
	{
		x = x / 8;
		i++;
	}
	p = (char *)malloc(sizeof(p) * i + 1);
	if (p)
	{
		p[i + 1] = '\0';
		while (i >= 0)
		{
			x = n % 8;
			p[i] = 48 + x;
			n = n/ 8;
			i--;
		}
	}
	return (p);
}
