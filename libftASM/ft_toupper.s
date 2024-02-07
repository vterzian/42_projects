# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_toupper.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:55:40 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:41:44 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global	_ft_toupper
extern	_ft_islower

section .text

_ft_toupper:
	call	_ft_islower
	cmp		rax, 0
	je		false
	sub		rdi, 32
	mov		rax, rdi
	ret
	

false:
	mov rax, rdi
	ret
