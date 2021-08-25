# Secrets

We are given a packet capture file. On opening it in Wireshark, we can see that it contains TLS traffic and USB traffic. These are probably the two paths the question refers to. Since TLS is encrypted("locked"), it could mean that its SSL key log file could be there in the USB traffic.

On looking through the pcap, or by searching for 'secrets' in packet bytes, we find the following packet:

![secrets](https://imgur.com/wuDclLe.png)

This is a SSL key log file which can be used to decrypt the TLS traffic. Export its packet bytes ( `Ctrl+Shift+X` ) and save it in a file. Now let's use this file in wireshark to decrypt the TLS traffic. We can do so in Wireshark as follows:

`Edit -> Preferences -> Protocols -> TLS -> (Pre)-Master-Secret log filename`

Now, we have the decrypted HTTP traffic. On following the HTTP stream, we get the flag:

![stream](https://imgur.com/GjbPeCQ.png)
