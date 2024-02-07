# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isspace.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/27 18:26:25 by vterzian          #+#    #+#              #
#    Updated: 2015/04/27 18:26:27 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global	_ft_isspace

section .text

_ft_isspace:
	cmp rdi, ' '
	je true
	cmp rdi, 9
	jl false
	cmp rdi, 13
	jg false

true:
	mov rax, 1
	ret

false:
	mov rax, 0
	ret
