# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isalpha.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/17 18:12:57 by vterzian          #+#    #+#              #
#    Updated: 2015/04/27 18:19:18 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_isalpha

section .text

_ft_isalpha:
	cmp	rdi, 'A'
	jl	false
	cmp	rdi, 'z'
	jg	false
	cmp rdi, 'Z'
	jle	true
	cmp rdi, 'a'
	jge	true

false:
	mov rax, 0
	ret

true:
	mov	rax, 1
	ret
