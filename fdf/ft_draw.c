/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_draw.c                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/12/15 13:23:34 by vterzian          #+#    #+#             */
/*   Updated: 2015/01/22 16:21:58 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "fdf.h"

void	ft_draw_y(t_env *env, t_2d *pt3d)
{
	float	x1;
	float	y1;
	float	x2;
	float	y2;
	float	y;

	x1 = pt3d->dx;
	y1 = pt3d->dy;
	y = y1;
	x2 = pt3d->x;
	y2 = pt3d->y;
	
	while (y >= y2)
	{
		ft_put_pixel_to_img(COLOR + (pt3d->z * 6), env,
		x1 + ((x2 - x1) * (y - y1)) / (y2 - y1), y);
		y--;
	}
}

void	ft_draw_line(t_env *env, t_2d *pt3d)
{
	float	x1;
	float	y1;
	float	x2;
	float	y2;
	float	x;
	
	x1 = pt3d->x;
	x = x1;
	y1 = pt3d->y;
	x2 = pt3d->next->x;
	y2 = pt3d->next->y;
	while (x <= x2)
	{
			ft_put_pixel_to_img(COLOR + (pt3d->z * 6), env, x,
			y1 + ((y2 - y1) * (x - x1)) / (x2 - x1));
			x++;
	}
}


void	ft_put_pixel_to_img(unsigned long color, t_env *env, int x, int y)
{
	int				i;
	unsigned char	col[(env->img->bpp / 8) - 1];

	i = 0;
	if (x < env->width && y < env->height && y >= 0 && x >= 0)
	{
		while (i < (env->img->bpp / 8) - 1)
		{
			col[i] = mlx_get_color_value(env->mlx, color) >> (i * 8);
			i++;
		}
		while (i >= 0)
		{
			env->img->data
			[y * env->img->sizeline + x * env->img->bpp / 8 + i] = col[i];
			i--;
		}
	}
}

void	ft_draw_data(t_env *env)
{
	t_2d	*tmp;
	t_3d	*pt3d;
	t_2d	*ptiso;

	pt3d = ft_set_3d(env);
	ptiso = ft_set_iso(env, pt3d);
	tmp = ptiso;
	env->img->data = mlx_get_data_addr(env->img->img_ptr,
	&env->img->bpp, &env->img->sizeline, &env->img->endian);
	while (tmp->next != NULL)
	{
		ft_draw_line(env, tmp);
		ft_draw_y(env, tmp);
		tmp = tmp->next;
	}
}
