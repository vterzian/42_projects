/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   fdf.h                                              :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/12/10 13:25:22 by vterzian          #+#    #+#             */
/*   Updated: 2015/01/22 16:29:42 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#ifndef FDF_H
# define FDF_H

# include "mlx.h"
# include <fcntl.h>
# include <math.h>
# include "get_next_line.h"

# define	W_WIDTH		1900
# define	W_HEIGHT	1200
# define	SPACE		20
# define	DEEP		0
# define	COLOR		0x3D63FF
# define	CTE1		0.7
# define	CTE2		0.9

typedef	struct	s_3d	t_3d;
struct	s_3d
{
	float		x;
	float		y;
	float		dx;
	float		dy;
	int			dz;
	int			z;
	t_3d	*next;
};

typedef	struct	s_2d	t_2d;
struct	s_2d
{
	float		x;
	float		y;
	float		dx;
	float		dy;
	int			z;
	int			dz;
	t_2d	*next;
};

typedef struct	s_img
{
	void	*img_ptr;
	int		width;
	int		height;
	char	*data;
	int		bpp;
	int		sizeline;
	int		endian;
}				t_img;

typedef struct	s_map
{
	int		width;
	int		height;
	int		**data;
}				t_map;

typedef struct	s_env
{
	char	*file;
	void	*mlx;
	void	*win;
	int		width;
	int		height;
	int		space;
	float	deep;
	int		startx;
	int		starty;
	t_img	*img;
	t_map	*map;
}				t_env;

int		ft_fdf_lauch(char *file, t_env *env);
t_map	*ft_fdf_get_map(char *file);
t_map	*ft_fdf_get_line(t_map *map, char *line, int i);
int		*ft_fdf_fill_map(char **split, int len);
int		ft_fdf_count_line(char *file);
int		ft_fdf_count_collumn(char *file);
void	ft_exit(t_env *env);
int		ft_key_hook(int key, t_env *env);
int		ft_mouse_hook(int button, int x, int y, t_env *env);
int		ft_expose_hook(t_env *env);
void	ft_draw_data(t_env *env);
void	ft_draw_line(t_env *env, t_2d *pt3d);
void	ft_draw_y(t_env *env, t_2d *pt3d);
t_3d	*ft_malloc_3d(t_3d *pt3d, int x, int y);
t_3d	*ft_fill_3d(t_env *env, t_3d *pt3d, int x, int y);
t_3d	*ft_set_3d(t_env *env);
t_2d	*ft_malloc_iso(t_2d *pt2d, int x, int y);
t_2d	*ft_fill_iso(t_env *env, t_2d *pt2d, t_3d *pt3d);
t_2d	*ft_set_iso(t_env *env, t_3d *pt3d); 
void	ft_put_pixel_to_img(unsigned long color, t_env *env, int x, int y);

#endif
