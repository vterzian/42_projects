section .text
	global _main
	extern _printf
	extern _fflush

_func:
	ret

;comment

_main:
	sub rsp, 0x8
	lea rdi, [rel str]
	mov rsi, 0xA
	mov rdx, 0x09
	mov rcx, 0x22
	lea r8, [rel str]
	mov r9, 0x3B
	;comment
	call _func
	call _printf
	mov rdi, 0x0
	call _fflush

_exit:
	mov rax, 0x2000001
	mov rdi, 0x0
	syscall

section .data
	str: db "section .text%1$c%2$cglobal _main%1$c%2$cextern _printf%1$c%2$cextern _fflush%1$c%1$c_func:%1$c%2$cret%1$c%1$c%5$ccomment%1$c%1$c_main:%1$c%2$csub rsp, 0x8%1$c%2$clea rdi, [rel str]%1$c%2$cmov rsi, 0xA%1$c%2$cmov rdx, 0x09%1$c%2$cmov rcx, 0x22%1$c%2$clea r8, [rel str]%1$c%2$cmov r9, 0x3B%1$c%2$c%5$ccomment%1$c%2$ccall _func%1$c%2$ccall _printf%1$c%2$cmov rdi, 0x0%1$c%2$ccall _fflush%1$c%1$c_exit:%1$c%2$cmov rax, 0x2000001%1$c%2$cmov rdi, 0x0%1$c%2$csyscall%1$c%1$csection .data%1$c%2$cstr: db %3$c%4$s%3$c%1$c"
