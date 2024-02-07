# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_strlen.s                                        :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 17:39:35 by vterzian          #+#    #+#              #
#    Updated: 2015/04/28 20:22:44 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_strlen

section .text

_ft_strlen:
	cmp	rdi, 0
	je	null
	mov rcx, -1
	xor al, al
	repne scasb
	not rcx
	dec rcx
	
	mov rax, rcx	
	ret

null:
	mov rax, 0
	ret
