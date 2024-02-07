/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_set_iso.c                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2015/01/22 15:54:17 by vterzian          #+#    #+#             */
/*   Updated: 2015/01/22 16:29:48 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "fdf.h"

t_2d	*ft_malloc_iso(t_2d *pt2d, int x, int y)
{
	if (x == 0 && y == 0)
		pt2d = malloc(sizeof(*pt2d));
	else
	{
		pt2d->next = malloc(sizeof(*pt2d));
		pt2d = pt2d->next;
	}
	return (pt2d);
}

t_2d	*ft_fill_iso(t_env *env, t_2d *pt2d, t_3d *pt3d)
{
	pt2d->x = CTE1 * pt3d->x - CTE2 * pt3d->y + env->startx;
	pt2d->y = pt3d->z * env->deep + (CTE1 / 2) * pt3d->x + 
	(CTE2 / 2) * pt3d->y + env->starty;
	pt2d->dx = CTE1 * pt3d->dx - CTE2 * pt3d->dy + env->startx;
	pt2d->dy = pt3d->dz * env->deep
	+ (CTE1 / 2) * pt3d->dx + (CTE2 / 2) * pt3d->dy + env->starty;
	pt2d->z = pt3d->z;
	pt2d->dz = pt3d->dz;
	pt2d->next = NULL;
	return (pt2d);
}

t_2d	*ft_set_iso(t_env *env, t_3d *pt3d)
{
	int		x;
	int		y;
	t_2d	*pt2d;
	t_2d	*tmp;

	y = 0;
	while (env->map->height > y)
	{
		x = 0;
		while (env->map->width > x)
		{
			pt2d = ft_malloc_iso(pt2d, x, y);
			pt2d = ft_fill_iso(env, pt2d, pt3d);
			if (x == 0 && y == 0)
				tmp = pt2d;
			else
				pt3d = pt3d->next;
			x++;
		}
		y++;
	}
	return (tmp);
}
