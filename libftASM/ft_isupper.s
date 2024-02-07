# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isupper.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:56:23 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:40:23 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_isupper

section .text

_ft_isupper:
	cmp	rdi, 65
	jl	false
	cmp rdi, 90
	jg	false

true:
	mov	rax, 1
	ret

false:
	mov	rax, 0
	ret
