# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_isalnum.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/18 14:55:55 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:41:53 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_isalnum
extern _ft_isalpha
extern _ft_isdigit

section .text

_ft_isalnum:
	call	_ft_isalpha
	cmp		rax, 1
	je		true
	call	_ft_isdigit
	cmp		rax, 1
	je		true

false:
	mov		rax, 0
	ret

true:
	ret
