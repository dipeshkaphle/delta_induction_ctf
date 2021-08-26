All three parties are using Diffie-Hellman key exchange.
To get the encrypted flag, all three parties must have the same secret.
We are allowed to manipulate what is communicated between them.

Pass ```P-1``` as the base so the secret would become ```(P-1) ^ private MOD P``` which has a value of:
*   ```1``` if ```private``` is even
*   ```P-1``` if the ```private is odd```

Since the algorithm would reject if the base is 1 so we need all three ```private``` to be odd.
That has a probability of 1/8, so keep trying until they all are odd simultaneously.

This way all three parties would have ```P-1``` as their secrets.

```python
from ptrlib import Socket
from Crypto.Util.number import long_to_bytes
from Crypto.Util.Padding import unpad
from Crypto.Cipher import AES
import hashlib
import time

while True:
    time.sleep(1)
    sock = Socket("host", port)
    p = 169622824183424820825728324890204115101468714952998142585574034795946851153950475569207215681807529286667189170420372861538287664283023804761495759297626394111153684529019990561684722443184304549649494421130078368098045597169822975289983997491594344239614944483399038130689027660812095676588300142576532463429

    sock.sendlineafter("Forward to Akarsh: ", str(p - 1))
    P = int(sock.recvlineafter("Sandhya: "))
    if P == 1:
        sock.close()
        continue
    sock.sendlineafter("Forward to Sandhya: ", str(P))
    print("PASSED 1")

    sock.sendlineafter("Forward to Sandhya: ", str(p - 1))
    Q = int(sock.recvlineafter("Anurag: "))
    if Q == 1:
        sock.close()
        continue
    sock.sendlineafter("Forward to Anurag: ", str(Q))
    print("PASSED 2")

    sock.sendlineafter("Forward to Anurag: ", str(p - 1))
    R = int(sock.recvlineafter("Akarsh: "))
    if R == 1:
        sock.close()
        continue
    sock.sendlineafter("Forward to Akarsh: ", str(R))
    print("PASSED 3")

    print(sock.recvline())
    cipher = sock.recvline().decode()
    if "TERMINATE" in cipher:
        sock.close()
        continue

    key = hashlib.sha1(long_to_bytes(p - 1)).digest()[:16]
    iv, encrypted = bytes.fromhex(cipher[:32]), bytes.fromhex(cipher[32:])
    flag = AES.new(key, AES.MODE_CBC, iv).decrypt(encrypted)
    flag = unpad(flag, AES.block_size).decode()
    print(flag)

    break

```

Flag: ```dctf{m4n_1n_7h3_m1ddl3_g1v1n_d1ff13_h311}```
