CC = nasm
LINKER = gcc
FLAGS = -f macho64

all: colleen grace sully

colleen:
	$(CC) $(FLAGS) colleen.s
	$(LINKER) colleen.o -o Colleen

grace:
	$(CC) $(FLAGS) grace.s
	$(LINKER) grace.o -o Grace

sully:
	$(CC) $(FLAGS) sully.s
	$(LINKER) sully.o -o Sully
	
clean:
	rm -f colleen.o grace.o sully.o Sully_5.o Sully_4.o Sully_3.o Sully_2.o Sully_1.o

fclean: clean
	rm -f Colleen Grace Sully Sully_*
	rm -f Grace_kid.s Sully_0.s Sully_1.s Sully_2.s Sully_4.s Sully_5.s
	
re: fclean all
