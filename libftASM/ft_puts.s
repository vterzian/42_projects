# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_puts.s                                          :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 17:38:41 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 17:39:28 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

%define CALL(nb)	0x2000000 | nb
%define WRITE		0x4
%define STDOUT		0x1
	
global _ft_puts
extern _ft_strlen

section .data
null:
	.string db "(null)"

section .text

_ft_puts:
	cmp rdi, 0x0
	je	ifnull
	push rdi
	call _ft_strlen
	mov rdx, rax
	pop rsi
	mov rdi, STDOUT
	mov rax, CALL(WRITE)
	syscall
	jmp nl

ifnull:
	mov rdi, STDOUT
	lea rsi, [rel null.string]
	mov	rdx, 6
	mov rax, CALL(WRITE)
	syscall

nl:
	push 0xa
	mov rsi, rsp
	mov rdi, STDOUT
	mov rdx, 1
	mov rax, CALL(WRITE)
	syscall
	pop rax
	ret 
	
