/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   fdf.c                                              :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/12/10 13:25:27 by vterzian          #+#    #+#             */
/*   Updated: 2015/01/22 16:29:44 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "fdf.h"

void	ft_exit(t_env *env)
{
	free(env->map->data);
	free(env->map);
	exit (0);
}

int		ft_mouse_hook(int button, int x, int y, t_env *env)
{
	(void)x;
	(void)y;
	if (button == 1)
	{
		env->space += 1;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else if (button == 3)
	{
		env->space -= 1;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else
	{
		ft_putstr("Mouse = ");
		ft_putnbr(button);
		ft_putchar('\n');
	}
	return (0);
}

int		ft_key_hook(int key, t_env *env)
{
	if (key == 65307)
		ft_exit(env);
	else if (key == 65362)
	{
		env->starty -= 5;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else if (key == 65364)
	{
		env->starty += 5;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else if (key == 65361)
	{
		env->startx -= 5;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else if (key == 65363)
	{
		env->startx += 5;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else if (key == 65453)
	{
		env->deep += 1;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else if (key == 65451)
	{
		env->deep -= 1;
		mlx_destroy_image(env->mlx, env->img->img_ptr);
		ft_expose_hook(env);
	}
	else
	{
		ft_putstr("Key = ");
		ft_putnbr(key);
		ft_putchar('\n');
	}
	return (0);
}

int		ft_expose_hook(t_env *env)
{
	env->img->img_ptr = mlx_new_image(env->mlx, W_WIDTH, W_HEIGHT);
	ft_draw_data(env);
	mlx_put_image_to_window(env->mlx, env->win, env->img->img_ptr, 0, 0);
	return (0);
}

int		ft_fdf_lauch(char *file, t_env *env)
{
	env->file = file;
	env->width = W_WIDTH;
	env->height = W_HEIGHT;
	env->startx = 500;
	env->starty = 0;
	env->mlx = mlx_init();
	env->map = ft_fdf_get_map(env->file);
	env->space = SPACE;
	env->deep = -DEEP;
	if (env->mlx != NULL)
	{
		env->img = malloc(sizeof(t_img));
		env->win = mlx_new_window(env->mlx, env->width, env->height, "FDF");
		mlx_expose_hook(env->win, ft_expose_hook, env);
		mlx_key_hook(env->win, ft_key_hook, env);
		mlx_mouse_hook(env->win, ft_mouse_hook, env);
		mlx_loop(env->mlx);
	}
	return (0);
}
