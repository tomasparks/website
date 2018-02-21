---
layout: ebook
title: Network layer
---

# Network layer #
  * Most of the network layers except Sneakernet and IP stack were build with analogue landline modems
  * the IP stack was build on a lease line network
  * Sneakernet has been the early way of transferring data/documents/letters since the beginning of recoded history (Mail, Pony Express, etc )

## Xmodem / SEALink / Telink / Zmodem ##
I am unsure witch modem file transfer protocol is the best, I am tossing up between Sealink, TeLink and Zmodem
### Xmodem ###
>  XMODEM is a simple file transfer protocol developed as a quick hack by Ward Christensen for use in his 1977 MODEM.ASM terminal program. It allowed users to transmit files between their computers when both sides used MODEM. Keith Petersen made a minor update to always turn on "quiet mode", and called the result XMODEM.
- <https://en.wikipedia.org/wiki/XMODEM>
### SEALink ###
>  SEAlink is a file transfer protocol that is backward compatible with XMODEM but features a sliding window system for improved throughput. SEAlink was written in 1986 as a part of the SEAdog FidoNet mailer written by System Enhancement Associates. It was licensed with a simple "give credit" requirement, but nevertheless was not very widely used except in FidoNet mailers. SEAlink, and most other XMODEM enhancements, were quickly displaced following the introduction of ZMODEM.
- https://en.wikipedia.org/wiki/SEAlink
### TeLink ###
>  MODEM7 sent the filename as normal text, which meant it could be corrupted by the same problems that XMODEM was attempting to avoid. This led to the introduction of TeLink by Tom Jennings, author of the original FidoNet mailers.
>  TeLink avoided MODEM7's problems by standardizing a new "zero packet" containing information about the original file. This included the file's name, size, and timestamp, which were placed in a regular 128 byte XMODEM block. Whereas a normal XMODEM transfer would start with the sender sending "block 1", the TeLink header packet was labeled "block 0".
>  The basic "block 0" system became a standard in the FidoNet community, and was re-used by a number of future protocols like SEAlink and YMODEM.
- <https://en.wikipedia.org/wiki/XMODEM>
### Zmodem ###
>  ZMODEM is a file transfer protocol developed by Chuck Forsberg in 1986, in a project funded by Telenet in order to improve file transfers on their X.25 network. In addition to dramatically improved performance compared to older protocols, ZMODEM also offered restartable transfers, auto-start by the sender, an expanded 32-bit CRC, and control character quoting, allowing it to be used on networks that might "eat" control characters. ZMODEM became extremely popular on bulletin board systems (BBS) in the early 1990s, displacing earlier protocols such as XMODEM and YMODEM.
- <https://en.wikipedia.org/wiki/ZMODEM>
### AX.25 / Packet Radio ###
> AX.25 is a data link layer protocol derived from the X.25 protocol suite and designed for use by amateur radio operators. It is used extensively on amateur packet radio networks.
> AX.25 v2.0 and later occupies the data link layer, the second layer of the OSI model. It is mainly responsible for establishing connections and transferring data encapsulated in frames between nodes and detecting errors introduced by the communications channel. As AX.25 is a pre-OSI-model protocol, the original specification was not written to cleanly separate into OSI layers. This was rectified with version 2.0 (1984), which assumes compliance with OSI level 2.
> In practice, it is not uncommon to find an AX.25 data link layer as the transport for some other network layer, such as IPv4, with TCP used on top of that. Note that, like Ethernet, AX.25 frames are not engineered to support switching. For this reason, AX.25 supports a somewhat limited form of source routing. Although possible to build AX.25 switches in a manner not unlike how Ethernet switches work, this has not yet been accomplished.
- https://en.wikipedia.org/wiki/AX.25
limited to 1200 bits per second audio frequency-shift keying (AFSK) is this correct?
very long history of use starting in 1971, lead to birth of the Ethernet standard and all modern wireless digital networks
### UUCP ###
> UUCP is an abbreviation of Unix-to-Unix Copy. The term generally refers to a suite of computer programs and protocols allowing remote execution of commands and transfer of files, email and netnews between computers.
- https://en.wikipedia.org/wiki/UUCP

### SneakerNet ###
Sneakernet is an informal term describing the transfer of electronic information, especially computer files, by physically moving removable media such as magnetic tape, floppy disks, compact discs, USB flash drives (thumb drives, USB stick) or external hard drives from one computer to another, usually in lieu of transmitting the information over a computer network. The term, a tongue-in-cheek play on Ethernet,refers to the use of someone wearing sneakers as the transport mechanism for the data.
- https://en.wikipedia.org/wiki/Sneakernet
IP over Avian Carriers
In computer networking, IP over Avian Carriers (IPoAC) is a humorously intended proposal to carry Internet Protocol (IP) traffic by birds such as homing pigeons. IP over Avian Carriers was initially described in RFC 1149, issued by the Internet Engineering Task Force (IETF) written by D. Waitzman and released on April 1, 1990.
IPoAC has been successfully implemented, but for only nine packets of data, with a packet loss ratio of 55% (due to user error),[2] and a response time ranging from 3000 seconds (~54 minutes) to over 6000 seconds (~1.77 hours). Thus, this technology suffers from poor latency. Nevertheless, for large transfers, avian carriers are capable of high average throughput when carrying flash memory devices, effectively implementing a sneakernet. During the last 20 years, the information density of storage media and thus the bandwidth of an avian carrier has increased 3 times as fast as the bandwidth of the Internet.[3] IPoAC may achieve bandwidth peaks of orders of magnitude more than the Internet when used with multiple avian carriers in rural areas. For example: If 16 homing pigeons are given eight 512 GB SD cards each, and take an hour to reach their destination, the throughput of the transfer would be 145.6 Gbit/s, excluding transfer to and from the SD cards.
https://en.wikipedia.org/wiki/IP_over_Avian_Carriers
IP Stack

Application
Transport
Internet/Network
Data Link/Link
Physical
Table 1: IP Stack
