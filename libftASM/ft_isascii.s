# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isascii.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:54:10 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 22:24:51 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_isascii

section .text

_ft_isascii:
	cmp	rdi, 0
	jl	false
	cmp rdi, 127
	jg	false

true:
	mov	rax, 1
	ret

false:
	mov rax, 0
	ret
