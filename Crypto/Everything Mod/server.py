from Crypto.Cipher import AES
from Crypto.Util.number import long_to_bytes
from Crypto.Util.Padding import pad
from random import randint
from os import urandom
import hashlib


class DiffHell:
    def __init__(self):
        self.N = 2
        self.P = 169622824183424820825728324890204115101468714952998142585574034795946851153950475569207215681807529286667189170420372861538287664283023804761495759297626394111153684529019990561684722443184304549649494421130078368098045597169822975289983997491594344239614944483399038130689027660812095676588300142576532463429
        self.private = randint(1, self.P - 1)
        self.secret = None

    def public_key(self):
        return pow(self.N, self.private, self.P)

    def share(self, base):
        assert base > 1 and base < self.P
        return pow(base, self.private, self.P)

    def shared_secret(self, base):
        assert base > 1 and base < self.P
        self.secret = pow(base, self.private, self.P)

    def signature(self):
        return hashlib.sha256(long_to_bytes(self.secret)).hexdigest()

    def verify_signature(self, sig1, sig2):
        return self.signature() == sig1 == sig2

    def encrypt_flag(self):
        iv = urandom(AES.block_size)
        key = hashlib.sha1(long_to_bytes(self.secret)).digest()[:16]
        flag = open('flag.txt', 'rb').read()
        cipher = iv.hex()
        cipher += AES.new(key, AES.MODE_CBC, iv).encrypt(pad(flag, AES.block_size)).hex()
        return cipher


Anurag = DiffHell()
Akarsh = DiffHell()
Sandhya = DiffHell()

An = Anurag.public_key()
print(f"Anurag sends to Akarsh: {An}")
An = int(input("Forward to Akarsh: "))
Ak = Akarsh.share(An)
print(f"Akarsh sends to Sandhya: {Ak}")
Ak = int(input("Forward to Sandhya: "))
Sandhya.shared_secret(Ak)

Ak = Akarsh.public_key()
print(f"Akarsh sends to Sandhya: {Ak}")
Ak = int(input("Forward to Sandhya: "))
Sa = Sandhya.share(Ak)
print(f"Sandhya sends to Anurag: {Sa}")
Sa = int(input("Forward to Anurag: "))
Anurag.shared_secret(Sa)

Sa = Sandhya.public_key()
print(f"Sandhya sends to Anurag: {Sa}")
Sa = int(input("Forward to Anurag: "))
An = Anurag.share(Sa)
print(f"Anurag sends to Akarsh: {An}")
An = int(input("Forward to Akarsh: "))
Akarsh.shared_secret(An)

print("Anurag says: ")

if (Anurag.verify_signature(Akarsh.signature(), Sandhya.signature())):
    print(Anurag.encrypt_flag())
else:
    print("TERMINATE!!! Somebody is listening!")
