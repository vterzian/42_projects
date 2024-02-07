# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_cat.s                                           :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 17:40:54 by vterzian          #+#    #+#              #
#    Updated: 2015/04/28 20:26:11 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

%define STDOUT 0x1
%define CALL(nb) 0x2000000 | nb
%define WRITE 0x4
%define READ 0x3

global	_ft_cat

section .data
	buff times 0xF0000 db 0

section .text

_ft_cat:
	mov	rcx, rdi
	lea	rsi, [rel buff]
	mov	rdx, 0xF0000
	mov	rax, CALL(READ)
	syscall
	jc	end
	cmp	rax, 0
	jle	end
	mov rdi, STDOUT
	mov rdx, rax
	mov rax, CALL(WRITE)
	syscall
	jc	end
	mov rdi, rcx
	jmp _ft_cat

end:
	ret
