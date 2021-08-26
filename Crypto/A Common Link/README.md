# A Common Link

Here the flag is encoded with five different RSA key pairs, but two of them have a common divisor. Consider n1 and n2 as follows:
n1 = p * q1
n2 = p * q2

Here p, q1, q2 are prime numbers. All we need to do is to check which of the two n values don't have GCD equal to 1.
Calculate p, q (n1/p). Calculate the private key and decrypt the cipher corresponding to the n value.

```python
from Crypto.Util.number import getPrime, GCD, inverse
from Crypto import Random
from Crypto.PublicKey import RSA
from Crypto.Cipher import PKCS1_OAEP
import base64
import sys


pub1 = RSA.importKey(open("pub1.pem", "rb").read(), passphrase=None)
e1 = pub1.e
n1 = pub1.n

pub2 = RSA.importKey(open("pub2.pem", "rb").read(), passphrase=None)
e2 = pub2.e
n2 = pub2.n

pub3 = RSA.importKey(open("pub3.pem", "rb").read(), passphrase=None)
e3 = pub3.e
n3 = pub3.n

pub4 = RSA.importKey(open("pub4.pem", "rb").read(), passphrase=None)
e4 = pub4.e
n4 = pub4.n

pub5 = RSA.importKey(open("pub5.pem", "rb").read(), passphrase=None)
e5 = pub5.e
n5 = pub5.n

myList = [(n1,e1),(n2,e2),(n3,e3),(n4,e4),(n5,e5)]

def decrypt_public_key(encoded_encrypted_msg, private_key):
    encryptor = PKCS1_OAEP.new(private_key)
    decoded_encrypted_msg = base64.b64decode(encoded_encrypted_msg)
    decoded_decrypted_msg = encryptor.decrypt(decoded_encrypted_msg)
    return decoded_decrypted_msg

cipher = "i6KIoR302eoOK4aYy1R9m6vpe8pOk+GOoKxlAhO53agYhIXXCzXdExXCBZk04W3P6BvHZmcYx+trael9m9sCU21+MYIc9xxHPcizMxQRP4CFcmrHrDiyfnsMaNSMaoQ3Mbxjqs0JLmALKfJcf8dZByEVf8lXP4i1wINFXhZs140="
for i in range(len(myList)):
    for j in range(len(myList)):
        if (i!=j and GCD(myList[i][0],myList[j][0])!=1):
            p = GCD(myList[i][0],myList[j][0])
            q = myList[i][0]//p
            phi = (p-1)*(q-1)
            e = myList[i][1]
            n = myList[i][0]
            d = inverse(e,phi)
            key = RSA.construct((n, e, d), consistency_check=True)
            private_key = RSA.importKey(key.export_key(), passphrase=None)
            print(decrypt_public_key(cipher, private_key).decode("utf-8"))
            sys.exit()
```