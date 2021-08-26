All executable files have the same header of 64-bits
```7f 45 4c 46 02 01 01 00```

You can see it by ```readelf -h executable```
```
ELF Header:
  Magic:   7f 45 4c 46 02 01 01 00 00 00 00 00 00 00 00 00 
  Class:                             ELF64
  Data:                              2's complement, little endian
  Version:                           1 (current)
  OS/ABI:                            UNIX - System V
  ABI Version:                       0
  Type:                              DYN (Shared object file)
  Machine:                           Advanced Micro Devices X86-64
  Version:                           0x1
  Entry point address:               0x1080
  Start of program headers:          64 (bytes into file)
  Start of section headers:          15328 (bytes into file)
  Flags:                             0x0
  Size of this header:               64 (bytes)
  Size of program headers:           56 (bytes)
  Number of program headers:         11
  Size of section headers:           64 (bytes)
  Number of section headers:         30
  Section header string table index: 29
```

Retrieve the encryption key by performing XOR between the first 64-bits of the encrypted file and the actual 64-bit executable header.

```python
def XOR(data1, data2):
    return bytes([data1[i] ^ data2[i] for i in range(len(data1))])


encrypted_data = open('encrypted', 'rb').read()

real_header = "7f 45 4c 46 02 01 01 00".split()
real_header = bytes([int(h, 16) for h in real_header])

xor_key = XOR(encrypted_data[:8], real_header)

decrypted_data = b''

with open('decrypted', 'wb') as decrypted:
    for i in range(0, len(encrypted_data), len(xor_key)):
        decrypted.write(XOR(encrypted_data[i:i+8], xor_key))
```

```chmod +x decrypted && ./decrypted```
```
Great! You used the fact that all executables have the same header!!
Flag: dctf{1t_w45_k1nd4_s1mpl3_l0l}
```
