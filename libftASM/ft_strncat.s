# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_strncat.s                                       :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/27 18:38:01 by vterzian          #+#    #+#              #
#    Updated: 2015/04/27 18:38:03 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global _ft_strncat

section .text

_ft_strncat:
	push rdi

loop:
	cmp byte[rdi], 0x0
	je	copy
	inc rdi
	jmp loop

copy:
	cmp	byte[rsi], 0x0
	je end
	cmp rdx, 0
	je end
	movsb
	dec rdx
	jmp	copy

end:
	pop rax
	ret
