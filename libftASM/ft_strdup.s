# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_strdup.s                                        :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 21:29:06 by vterzian          #+#    #+#              #
#    Updated: 2015/04/28 20:21:44 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global				_ft_strdup
extern				_ft_strlen
extern				_ft_memcpy
extern				_malloc

section				.text

_ft_strdup:
			push	rbp
			lea		rbp, [rsp]

			cmp 	rdi, 0
			je		null
			lea		r14, [rdi]
			call	_ft_strlen
			lea		r15, [rax]
			lea		rdi, [rax]
			inc		rdi

			call	_malloc
			cmp		rax, 0
			je		end
			lea		rdi, [rax]
			lea		rsi, [r14]
			lea		rdx, [r15]

			call	_ft_memcpy
			mov		[rax + r15], byte 0
end:
			leave
			ret

null:
		leave
		mov rax, 0
		ret
