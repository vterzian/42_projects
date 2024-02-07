# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_memset.s                                        :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 17:42:10 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 21:31:53 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_memset

section .text

_ft_memset:
	push rdi
	mov rcx, rdx
	mov rax, rsi
	cld
	rep stosb
	pop rax
	ret	
