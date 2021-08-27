FROM python:3.9-slim-buster

RUN apt-get update && \
    apt-get -y install --no-install-recommends autoconf bison flex gcc g++ gcc-multilib git libprotobuf-dev libnl-route-3-dev libtool make pkg-config protobuf-compiler && \
    git clone https://github.com/google/nsjail.git /nsjail && \
    cd /nsjail && make && cd / && \
    mv /nsjail/nsjail /bin && \
    rm -r /nsjail && \
    dpkg --add-architecture i386 && \
    apt-get update && apt-get -y install --no-install-recommends libc6-i386 libprotobuf-dev libnl-route-3-200 protobuf-compiler && \
    pip3 install --upgrade pip && \
    useradd -r -m -u 1000 ctf

ENV LD_LIBRARY_PATH=/usr/lib/x86_64-linux-gnu:/usr/local/lib

WORKDIR /home/ctf
