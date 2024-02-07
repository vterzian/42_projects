# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    Makefile                                           :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: vterzian <vterzian@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2014/11/19 14:33:32 by vterzian          #+#    #+#              #
#    Updated: 2018/03/20 14:09:11 by vterzian         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

NAME = libfts.a
SRC =	ft_bzero.s\
		ft_isalpha.s\
		ft_isdigit.s\
		ft_isalnum.s\
		ft_isascii.s\
		ft_isprint.s\
		ft_islower.s\
		ft_isupper.s\
		ft_isspace.s\
		ft_tolower.s\
		ft_toupper.s\
		ft_strcat.s\
		ft_strncat.s\
		ft_strdup.s\
		ft_strlen.s\
		ft_memcpy.s\
		ft_memset.s\
		ft_memalloc.s\
		ft_puts.s\
		ft_cat.s
OBJ = $(SRC:.s=.o)

CS = nasm
CC = clang

SFLAG = -f macho64
CFLAGS = -Wall -Wextra -Werror

.PHONY: re clean fclean all

all: $(NAME)

$(NAME): $(OBJ)
	@ar rc $(NAME) $(OBJ)
	@$(CC) $(CFLAGS) main.c $(NAME) -o libftasm_test
	@echo "- COMPILATION  DONE -"

%.o: %.s
	@$(CS) $(SFLAG) -o $@ $<

clean:
	@rm -f $(OBJ)
	@echo "- CLEAN DONE -"

fclean: clean
	@rm -f $(NAME)
	@echo "- FCLEAN DONE -"

re: fclean all

