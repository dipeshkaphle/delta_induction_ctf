The binary reads a file `flag.txt` and gives the encrypted output.
We can decompile the binary in Ghidra, and navigate to the `main` function, and we see the following decompilation.

```c
undefined4 main(void)

{
  char cVar1;
  int local_2c;
  int local_24;
  undefined4 local_20;
  char local_1c [20];
  undefined4 local_8;
  
  local_8 = 0;
  read_flag(local_1c);
  local_20 = strlen(local_1c);
  for (local_24 = 0; local_1c[local_24] != '\0'; local_24 = local_24 + 1) {
    if (local_24 % 2 == 0) {
      local_1c[local_24] = local_1c[local_24] + -1;
    }
    else {
      local_1c[local_24] = local_1c[local_24] + '\x01';
    }
  }
  for (local_2c = 0; local_2c < (int)local_20 / 2; local_2c = local_2c + 1) {
    cVar1 = local_1c[local_2c];
    local_1c[local_2c] = local_1c[(local_20 - local_2c) + -1];
    local_1c[(local_20 - local_2c) + -1] = cVar1;
  }
  puts(local_1c);
  return 0;
}
```

We can infer that there is a function called `read_flag` which probably reads the flag into the array `local_1c`.
Then there are two loops which process this array. First all the even position characters are decremented by 1 and the odd position characters are incremented by 1.
Then the string is reversed. Following the same process we can reverse the encrypted text to get the flag.
