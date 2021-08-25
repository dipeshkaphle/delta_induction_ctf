The given binary is a '.pyc' file, basically a compiled python file. On running
it with python, it just prints "Pretty useless binary". It doesnt make sense to
look at it like this. After a bit of searching around, we can use the script
![here](https://stackoverflow.com/questions/11141387/given-a-python-pyc-file-is-there-a-tool-that-let-me-view-the-bytecode/42720524)
to convert it to somewhat readable bytecode.

- disass.py

```python
import platform
import time
import sys
import binascii
import marshal
import dis
import struct



def view_pyc_file(path):
    """Read and display a content of the Python`s bytecode in a pyc-file."""

    file = open(path, 'rb')

    magic = file.read(4)
    bit_field = None
    timestamp = None
    hashstr = None
    size = None

    if sys.version_info.major == 3 and sys.version_info.minor >=7:
        bit_field = int.from_bytes(file.read(4), byteorder=sys.byteorder)
        if 1 & bit_field == 1:
            hashstr = file.read(8)
        else:
            timestamp = file.read(4)
            size = file.read(4)
            size = struct.unpack('I', size)[0]
    elif sys.version_info.major == 3 and sys.version_info.minor >= 3:
        timestamp = file.read(4)
        size = file.read(4)
        size = struct.unpack('I', size)[0]
    else:
        timestamp = file.read(4)


    code = marshal.load(file)

    magic = binascii.hexlify(magic).decode('utf-8')
    timestamp = time.asctime(time.localtime(struct.unpack('I', b'D\xa5\xc2X')[0]))

    dis.disassemble(code)

    print('-' * 80)
    print(
        'Python version: {}\nMagic code: {}\nTimestamp: {}\nSize: {}\nHash: {}\nBitfield: {}'
        .format(platform.python_version(), magic, timestamp, size, hashstr, bit_field)
    )

    file.close()

if __name__ == '__main__':
    view_pyc_file(sys.argv[1])

```

```bash
  1           0 BUILD_LIST               0
              2 LOAD_CONST               0 ((116, 104, 49, 115, 95, 49, 53, 95, 49, 110, 116, 114, 48, 95, 116, 48, 95, 114, 51, 118, 51, 114, 53, 49, 110, 103))
              4 LIST_EXTEND              1
              6 STORE_NAME               0 (flag)

  6           8 LOAD_NAME                1 (print)
             10 LOAD_CONST               1 ('Pretty useless binary')
             12 CALL_FUNCTION            1
             14 POP_TOP
             16 LOAD_CONST               2 (None)
             18 RETURN_VALUE

```

- We can see the values here for an array thats being assigned to a variable
  called flag. They all seem ascii.

```bash
>>> flag= [116, 104, 49, 115, 95, 49, 53, 95, 49, 110, 116, 114, 48, 95,116, 48, 95, 114, 51, 118, 51, 114, 53, 49, 110, 103]
>>> ''.join(list(map(lambda x: chr(x), flag)))
'th1s_15_1ntr0_t0_r3v3r51ng'
>>>

```

- We get our flag `dctf{th1s_15_1ntr0_t0_r3v3r51ng}`
