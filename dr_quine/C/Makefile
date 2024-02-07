CC = gcc
FLAGS = -Werror -Wall -Wextra

all: colleen grace sully

colleen:
	$(CC) $(FLAGS) Colleen.c -o Colleen

grace:
	$(CC) $(FLAGS) Grace.c -o Grace

sully:
	$(CC) $(FLAGS) Sully.c -o Sully

sclean:
	rm -f Sully_0\
		Sully_1\
		Sully_2\
		Sully_3\
		Sully_4\
		Sully_5\
		Sully_0.c\
		Sully_1.c\
		Sully_2.c\
		Sully_3.c\
		Sully_4.c\
		Sully_5.c\
		Grace_kid.c

clean:
	rm -f Colleen Grace Sully 

fclean: sclean clean

re: fclean all
