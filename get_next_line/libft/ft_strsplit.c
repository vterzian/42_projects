/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_strsplit.c                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2014/11/12 15:17:31 by vterzian          #+#    #+#             */
/*   Updated: 2014/11/25 21:06:12 by vterzian         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "libft.h"

static int		ft_count_word(char const *s, char c)
{
	int i;
	int	nbr;

	i = 0;
	nbr = 0;
	if (s == NULL)
		return (0);
	if (!c)
		return (0);
	while (s[i] != '\0')
	{
		while (s[i] == c && s[i] != '\0')
			i++;
		if (s[i] != '\0')
			nbr++;
		while (s[i] != c && s[i] != '\0')
			i++;
	}
	return (nbr);
}

static int		*ft_count_letter(char const *s, char c)
{
	int *tab;
	int i;
	int j;
	int k;

	i = 0;
	j = 0;
	k = 0;
	if (s == NULL && !c)
		return (0);
	tab = malloc(sizeof(int) * ft_count_word(s, c));
	while (s[i] != '\0')
	{
		while (s[i] == c && s[i] != '\0')
			i++;
		while (s[i] != c && s[i] != '\0')
		{
			j++;
			i++;
		}
		tab[k] = j;
		j = 0;
		k++;
	}
	return (tab);
}

static char		**ft_alloc_2dtab(int dim1, int *dim2)
{
	char	**tab;
	int		i;

	i = 0;
	tab = malloc(sizeof(char*) * dim1);
	if (tab == NULL)
		return (NULL);
	while (i < dim1)
	{
		tab[i] = ft_strnew(sizeof(char) * dim2[i]);
		i++;
	}
	return (tab);
}

char			**ft_strsplit(char const *s, char c)
{
	char	**tab;
	int		i;
	int		j;
	int		k;

	i = 0;
	j = 0;
	if (s == NULL)
		return (NULL);
	tab = ft_alloc_2dtab(ft_count_word(s, c), ft_count_letter(s, c));
	if (tab == NULL)
		return (NULL);
	while (s[i] != '\0')
	{
		k = 0;
		while (s[i] == c && s[i] != '\0')
			i++;
		while (s[i] != c && s[i] != '\0')
		{
			tab[j][k++] = s[i];
			i++;
		}
		j++;
	}
	return (tab);
}
