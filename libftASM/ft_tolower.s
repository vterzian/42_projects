# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_tolower.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:53:52 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:40:47 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global	_ft_tolower
extern	_ft_isupper

section .text

_ft_tolower:
	call	_ft_isupper
	cmp		rax, 0
	je		false
	add		rdi, 32
	mov		rax, rdi
	ret

false:
	mov	rax, rdi
	ret
