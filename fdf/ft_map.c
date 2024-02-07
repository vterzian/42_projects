/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_map.c                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/12/12 15:03:54 by vterzian          #+#    #+#             */
/*   Updated: 2015/01/22 15:18:05 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "fdf.h"

int		ft_count_collumn(char *file)
{
	int		fd;
	int		i;
	int		longer;
	char	*line;
	char	**split;

	fd = open(file, O_RDONLY);
	i = 0;
	longer = 0;
	while (get_next_line(fd, &line) > 0)
	{
		i = 0;
		split = ft_strsplit(line, ' ');
		while (split[i] != NULL)
			i++;
		if (longer < i)
			longer = i;
		ft_strdel(&line);
	}
	close(fd);
	return (longer);
}

int		ft_fdf_count_line(char *file)
{
	int		nbr_lines;
	int		fd;
	char	*line;

	fd = open(file, O_RDONLY);
	while (get_next_line(fd, &line) > 0)
	{
		nbr_lines++;
		ft_strdel(&line);
	}
	return (nbr_lines);
}

int		*ft_fdf_fill_map(char **split, int len)
{
	int	*line;
	int	tmp;
	int i;

	i = 0;
	line = (int*)malloc(sizeof(int*) * len);
	while (i < len + 1)
	{
		if (split[i])
		{
			tmp = ft_atoi(split[i]);
			line[i] = tmp;
		}
		else
			line[i] = 0;
		i++;
	}
	return (line);
}

t_map	*ft_fdf_get_line(t_map *map, char *line, int i)
{
	char	**split;

	split = ft_strsplit(line, ' ');
	map->data[i] = ft_fdf_fill_map(split, map->width);
	return (map);
}

t_map	*ft_fdf_get_map(char *file)
{
	t_map	*map;
	char	*line;
	int		i;
	int		fd;

	i = 0;
	map = malloc(sizeof(t_map*));
	map->height = ft_fdf_count_line(file);
	map->data = (int**)malloc(sizeof(int**) * map->height);
	fd = open(file, O_RDONLY);
	map->width = ft_count_collumn(file);
	while (get_next_line(fd, &line) > 0)
	{
		map = ft_fdf_get_line(map, line, i);
		ft_strdel(&line);
		i++;
	}
	close(fd);
	return (map);
}
