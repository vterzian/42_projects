/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_strsplit.c                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/11/12 15:17:31 by vterzian          #+#    #+#             */
/*   Updated: 2014/12/05 21:22:13 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "libft.h"

static size_t	ft_count_word(char const *s, char c)
{
	int	i;
	size_t j;

	i = 0;
	j = 0;
	while (s[i] != '\0')
	{
		while (s[i] == c)
			i++;
		if(s[i] != c && s[i] != '\0')
			j++;
		while (s[i] != c && s[i] != '\0')
			i++;
	}
	return (j);
}

static char	**ft_create_tab(size_t size)
{
	char	**tab;

	tab = (char**)ft_memalloc(sizeof(char**) * size + 1);
	if (tab == NULL)
	   return (NULL);	
	*tab = ft_strdup("");
	return (tab);
}

char			**ft_strsplit(char const *s, char c)
{
	char	**tab;
	char	*tmp;
	int 	i;
	int 	j;
	int 	n;
	size_t	nbw;
	
	if(s == NULL || !c)
		return (NULL);
	i = 0;
	j = 0;
	n = 0;
	nbw = ft_count_word(s, c);
	tab = ft_create_tab(nbw);
	tmp = ft_strdup(s);
	if (tab == NULL)
		return (NULL);
	while(tmp[i] != '\0')
	{
		while (tmp[i] == c)
			i++;
		j = i;
		while (tmp[j] != c && tmp[j] != '\0')
			j++;
		if ( tmp[j] != '\0' || tmp[i] != c)
			tab[n++] = ft_strsub(tmp, i, j - i);
		i = j;
	}
	tab[nbw] = NULL;
	ft_strdel(&tmp);
	return (tab);
}

