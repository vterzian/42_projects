# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_memalloc.s                                      :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/28 15:49:05 by vterzian          #+#    #+#              #
#    Updated: 2015/04/28 15:49:07 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_memalloc
extern _malloc
extern _ft_bzero

section .text

_ft_memalloc:
	push rbp
	lea rbp, [rsp]
	cmp rdi, 0
	je end
	lea r14, [rdi]

	call _malloc
	cmp rax, 0
	je end

	lea rdi, [rax]
	lea rsi, [r14]
	call _ft_bzero
	lea rax, [rdi]
	leave
	ret

end:
	mov rax, -1
	mov rdi, r14
	leave
	ret


