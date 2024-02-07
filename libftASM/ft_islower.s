# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_islower.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:53:20 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:41:59 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global	_ft_islower

section	.text

_ft_islower:
	cmp	rdi, 97
	jl	false
	cmp	rdi, 122
	jg	false

true:
	mov rax, 1
	ret

false:
	mov	rax, 0
	ret
