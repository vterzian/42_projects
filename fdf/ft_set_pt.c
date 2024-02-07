/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_set_pt.c                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/01/22 15:18:26 by vterzian          #+#    #+#             */
/*   Updated: 2015/01/22 16:29:46 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "fdf.h"

t_3d	*ft_malloc_3d(t_3d *pt3d, int x, int y)
{
	if (x == 0 && y == 0)
		pt3d = malloc(sizeof(*pt3d));
	else
	{
		pt3d->next = malloc(sizeof(*pt3d));
		pt3d = pt3d->next;
	}
	return (pt3d);	
}

t_3d	*ft_fill_3d(t_env *env, t_3d *pt3d, int x, int y)
{
	pt3d->x = x * env->space;
	pt3d->y = y * env->space;
	if (y + 1 < env->map->height)
	{
		pt3d->dx = pt3d->x;
		pt3d->dy = (y + 1) * env->space;
		pt3d->dz = env->map->data[y + 1][x];
	}
	pt3d->z = env->map->data[y][x];
	pt3d->next = NULL;
	return (pt3d);
}

t_3d	*ft_set_3d(t_env *env)
{
	int		x;
	int		y;
	t_3d	*pt3d;
	t_3d	*tmp;

	y = 0;
	while (env->map->height > y)
	{
		x = 0;
		while (x < env->map->width)
		{
			pt3d = ft_malloc_3d(pt3d, x, y);
			if ( x == 0 && y == 0)
				tmp = pt3d;
			pt3d = ft_fill_3d(env, pt3d, x, y);
			x++;
		}
		y++;
	}
	return (tmp);
}

