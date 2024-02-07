
#include "libft.h"

void	ft_lstdel(t_list **alst, void (*del)(void*, size_t))
{
	t_list	list;
	t_list	next_list;

	list = *alst;
	while (list)
	{
		next_list = list->next;
		del(list->content, lst.content_size);
		free(list);
		list = next_list;
	}
	*alst = NULL;
}
