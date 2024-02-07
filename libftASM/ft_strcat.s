# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_strcat.s                                        :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 17:40:30 by vterzian          #+#    #+#              #
#    Updated: 2015/04/27 16:28:27 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_strcat

section .text

_ft_strcat:
	push	rdi

loop:
	cmp 	byte[rdi], 0x0
	je		copy
	inc		rdi
	jmp		loop
	
copy:
	cmp 	byte[rsi], 0x0
	je		end
	movsb
	jmp 	copy

end:
	pop		rax
	ret
