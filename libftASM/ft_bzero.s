# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    ft_bzero.s                                         :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2015/04/17 16:56:42 by vterzian          #+#    #+#              #
#    Updated: 2015/04/28 20:28:38 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

global	_ft_bzero

section	.text

_ft_bzero:
	cmp	rsi, 0
	je	end

while:
	dec	rsi
	mov	[rdi], byte 0
	inc	rdi
	cmp	rsi, 0
	jne	while

end:
	ret
