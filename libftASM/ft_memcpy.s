# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_memcpy.s                                        :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/21 21:28:12 by vterzian          #+#    #+#              #
#    Updated: 2015/04/21 21:28:14 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #


global					_ft_memcpy

section					.text

_ft_memcpy:
			cmp	rdx, 0
			je	end
			mov	rcx, rdx
			rep	movsb
			ret
	end:
		mov	rax, rdi
		ret
