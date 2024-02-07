# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isprint.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:55:30 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:39:19 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global	_ft_isprint

section .text

_ft_isprint:
	cmp rdi, 32
	jl	false
	cmp rdi, 126
	jg	false

true:
	mov rax, 1
	ret

false:
	mov rax, 0
	ret
