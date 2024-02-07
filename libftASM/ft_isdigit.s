# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isdigit.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:56:14 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:41:02 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_isdigit

section .text

_ft_isdigit:
	cmp	rdi, 48
	jl	false
	cmp rdi, 57
	jg	false

true:
	mov rax, 1
	ret

false:
	mov rax, 0
	ret
