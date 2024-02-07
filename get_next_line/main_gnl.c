/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   main.c                                             :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/11/25 14:06:32 by vterzian          #+#    #+#             */
/*   Updated: 2014/11/27 17:11:17 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include <fcntl.h>
#include "get_next_line.h"

int	main(int argc, char **argv)
{
	int		fd;
	char	*tab;
	(void)argc;

	if (argc > 1)
		fd = open(argv[1], S_IRUSR);
	else
		fd = 0;
	while (get_next_line(fd, &tab) > 0)
	{
		ft_putendl(tab);
		ft_strdel(&tab);
	}
	return (0);
}

