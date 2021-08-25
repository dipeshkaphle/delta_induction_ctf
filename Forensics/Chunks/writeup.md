# Chunks

We are given a password protected ZIP file. It can be cracked using `rockyou.txt`, a popular dictionary file with commonly used passwords. We can crack it using `fcrackzip`, a tool for this purpose:

```bash
fcrackzip -v -u -D -p rockyou.txt chunks.zip
```

We get the password as **'sysadmin@!'**. On extracting the ZIP file, we find a PNG image which is corrupted.

On opening the PNG file, we find that the image headers of the critical chunks of a PNG file have been replaced with 'DCTF'.

![broken](https://imgur.com/KNg0enm.png)

 To replace these with the right header names we need to know that **a valid PNG image must contain an IHDR chunk, one or more IDAT chunks, and an IEND chunk.** Therefore, the first two 'DCTF's correspond to **89 50 4e 47**(PNGs magic number) and **'IHDR'**. The last one must be **'IEND'** and so the third one must be **'IDAT'**.

![fixed](https://imgur.com/VNts74X.png)

After fixing the PNG, we get a QR code, which on scanning gives us the flag.

```bash
zbarimg flag.png
```
