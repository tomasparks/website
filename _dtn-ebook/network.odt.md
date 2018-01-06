# Network layer

-   Most of the network layers except Sneakernet and IP stack were build with analogue landline modems

<!-- -->

-   the IP stack was build on a lease line network
-   Sneakernet has been the early way of transferring data/documents/letters since the beginning of recoded history (Mail, Pony Express, etc )

## <span id="anchor"></span><span id="Xmodem"></span>Xmodem / SEALink / Telink / Zmodem

I am unsure witch modem file transfer protocol is the best, I am tossing up between Sealink, TeLink and Zmodem

### <span id="anchor-1"></span>Xmodem

****XMODEM*** is a simple *[*file transfer*](https://en.wikipedia.org/wiki/File_transfer)* protocol developed as a quick *[*hack*](https://en.wikipedia.org/wiki/Hacker_%28hobbyist%29)* by *[*Ward Christensen*](https://en.wikipedia.org/wiki/Ward_Christensen)* for use in his 1977 ***MODEM.ASM*** *[*terminal program*](https://en.wikipedia.org/wiki/Terminal_program)*. It allowed users to transmit files between their computers when both sides used MODEM. Keith Petersen made a minor update to always turn on "quiet mode", and called the result XMODEM.*

- https://en.wikipedia.org/wiki/XMODEM

### <span id="anchor-2"></span>SEALink

****SEAlink*** is a *[*file transfer protocol*](https://en.wikipedia.org/wiki/File_transfer)* that is *[*backward compatible*](https://en.wikipedia.org/wiki/Backward_compatibility)* with *[*XMODEM*](https://en.wikipedia.org/wiki/XMODEM)* but features a *[*sliding window*](https://en.wikipedia.org/wiki/Sliding_window)* system for improved *[*throughput*](https://en.wikipedia.org/wiki/Throughput)*. SEAlink was written in 1986 as a part of the ***SEAdog*** *[*FidoNet*](https://en.wikipedia.org/wiki/FidoNet)* mailer written by *[*System Enhancement Associates*](https://en.wikipedia.org/w/index.php?title=System_Enhancement_Associates&action=edit&redlink=1)*. It was licensed with a simple "give credit" requirement, but nevertheless was not very widely used except in FidoNet mailers. SEAlink, and most other XMODEM enhancements, were quickly displaced following the introduction of *[*ZMODEM*](https://en.wikipedia.org/wiki/ZMODEM)*.*

- https://en.wikipedia.org/wiki/SEAlink

### <span id="anchor-3"></span><span id="anchor-4"></span>TeLink

*MODEM7 sent the filename as normal text, which meant it could be corrupted by the same problems that XMODEM was attempting to avoid. This led to the introduction of ***TeLink*** by *[*Tom Jennings*](https://en.wikipedia.org/wiki/Tom_Jennings)*, author of the original *[*FidoNet*](https://en.wikipedia.org/wiki/FidoNet)* mailers.*

*TeLink avoided MODEM7's problems by standardizing a new "zero packet" containing information about the original file. This included the file's name, size, and *[*timestamp*](https://en.wikipedia.org/wiki/Timestamp)*, which were placed in a regular 128 byte XMODEM block. Whereas a normal XMODEM transfer would start with the sender sending "block 1", the TeLink header packet was labeled "block 0".*

*The basic "block 0" system became a standard in the FidoNet community, and was re-used by a number of future protocols like *[*SEAlink*](https://en.wikipedia.org/wiki/SEAlink)* and *[*YMODEM*](https://en.wikipedia.org/wiki/YMODEM)*.*

- <https://en.wikipedia.org/wiki/XMODEM>

### <span id="anchor-5"></span>Zmodem

****ZMODEM*** is a *[*file transfer protocol*](https://en.wikipedia.org/wiki/Protocol_for_file_transfer)* developed by *[*Chuck Forsberg*](https://en.wikipedia.org/wiki/Chuck_Forsberg)* in 1986, in a *[*project*](https://en.wikipedia.org/wiki/Project)* funded by *[*Telenet*](https://en.wikipedia.org/wiki/Telenet)* in order to improve file transfers on their *[*X.25*](https://en.wikipedia.org/wiki/X.25)* network. In addition to dramatically improved performance compared to older protocols, ZMODEM also offered restartable transfers, auto-start by the sender, an expanded 32-bit *[*CRC*](https://en.wikipedia.org/wiki/Cyclic_redundancy_check)*, and *[*control character quoting*](https://en.wikipedia.org/wiki/Escape_character)*, allowing it to be used on networks that might "eat" control characters. ZMODEM became extremely popular on *[*bulletin board systems*](https://en.wikipedia.org/wiki/Bulletin_board_system)* (BBS) in the early 1990s, displacing earlier protocols such as *[*XMODEM*](https://en.wikipedia.org/wiki/XMODEM)* and *[*YMODEM*](https://en.wikipedia.org/wiki/YMODEM)*.*

- https://en.wikipedia.org/wiki/ZMODEM

## <span id="anchor-6"></span><span id="AX.25"></span>AX.25 / Packet Radio

****AX.25*** is a *[*data link layer*](https://en.wikipedia.org/wiki/Data_link_layer)* *[*protocol*](https://en.wikipedia.org/wiki/Protocol_%28computing%29)* derived from the *[*X.25*](https://en.wikipedia.org/wiki/X.25)* protocol suite and designed for use by *[*amateur radio*](https://en.wikipedia.org/wiki/Amateur_radio)* operators. It is used extensively on amateur *[*packet radio*](https://en.wikipedia.org/wiki/Packet_radio)* *[*networks*](https://en.wikipedia.org/wiki/Computer_network)*.*

*AX.25 v2.0 and later occupies the *[*data link layer*](https://en.wikipedia.org/wiki/Data_link_layer)*, the second layer of the *[*OSI model*](https://en.wikipedia.org/wiki/OSI_model)*. It is mainly responsible for establishing connections and transferring data encapsulated in *[*frames*](https://en.wikipedia.org/wiki/Frame_%28networking%29)* between *[*nodes*](https://en.wikipedia.org/wiki/Node_%28networking%29)* and detecting errors introduced by the *[*communications channel*](https://en.wikipedia.org/wiki/Communications_channel)*. As AX.25 is a pre-OSI-model protocol, the original specification was not written to cleanly separate into OSI layers. This was rectified with version 2.0 (1984), which assumes compliance with OSI level 2.*

*In practice, it is not uncommon to find an AX.25 data link layer as the transport for some other network layer, such as IPv4, with TCP used on top of that. Note that, like Ethernet, AX.25 frames are not engineered to support switching. For this reason, AX.25 supports a somewhat limited form of *[*source routing*](https://en.wikipedia.org/wiki/Source_routing)*. Although possible to build AX.25 switches in a manner not unlike how Ethernet switches work, this has not yet been accomplished.*

- https://en.wikipedia.org/wiki/AX.25

-   **limited to *1200 *[*bits per second*](https://en.wikipedia.org/wiki/Bits_per_second)* *[*audio frequency-shift keying*](https://en.wikipedia.org/wiki/Frequency-shift_keying)* (AFSK) *is this correct?**
-   very long history of use starting in 1971, lead to birth of the Ethernet standard and all modern wireless digital networks

## <span id="anchor-7"></span><span id="UUCP"></span>UUCP

****UUCP*** is an *[*abbreviation*](https://en.wikipedia.org/wiki/Abbreviation)* of ***Unix-to-Unix Copy***. The term generally refers to a suite of *[*computer programs*](https://en.wikipedia.org/wiki/Computer_program)* and *[*protocols*](https://en.wikipedia.org/wiki/Communications_protocol)* allowing remote execution of commands and transfer of *[*files*](https://en.wikipedia.org/wiki/Computer_file)*, *[*email*](https://en.wikipedia.org/wiki/Email)* and *[*netnews*](https://en.wikipedia.org/wiki/Netnews)* between *[*computers*](https://en.wikipedia.org/wiki/Computer)*.*

- <https://en.wikipedia.org/wiki/UUCP>

## <span id="anchor-8"></span><span id="SneakerNet"></span>SneakerNet

****Sneakernet*** is an informal term describing the transfer of electronic information, especially *[*computer files*](https://en.wikipedia.org/wiki/Computer_file)*, by physically moving removable media such as *[*magnetic tape*](https://en.wikipedia.org/wiki/Magnetic_tape)*, *[*floppy disks*](https://en.wikipedia.org/wiki/Floppy_disk)*, *[*compact discs*](https://en.wikipedia.org/wiki/Compact_disc)*, *[*USB flash drives*](https://en.wikipedia.org/wiki/USB_flash_drive)* (thumb drives, USB stick) or external *[*hard drives*](https://en.wikipedia.org/wiki/Hard_drive)* from one *[*computer*](https://en.wikipedia.org/wiki/Computer)* to another, usually in lieu of transmitting the information over a *[*computer network*](https://en.wikipedia.org/wiki/Computer_network)*. The term, a *[*tongue-in-cheek*](https://en.wikipedia.org/wiki/Tongue-in-cheek)* play on *[*Ethernet*](https://en.wikipedia.org/wiki/Ethernet)*,refers to the use of someone wearing *[*sneakers*](https://en.wikipedia.org/wiki/Sneakers_%28footwear%29)* as the transport mechanism for the data.*

- <https://en.wikipedia.org/wiki/Sneakernet>

### <span id="anchor-9"></span><span id="anchor-10"></span>IP over Avian Carriers

*In *[*computer networking*](https://en.wikipedia.org/wiki/Computer_networking)*, ***IP over Avian Carriers*** (IPoAC) is a humorously intended proposal to carry *[*Internet Protocol*](https://en.wikipedia.org/wiki/Internet_Protocol)* (IP) *[*traffic*](https://en.wikipedia.org/wiki/Internet_traffic)* by *[*birds*](https://en.wikipedia.org/wiki/Bird)* such as *[*homing pigeons*](https://en.wikipedia.org/wiki/Homing_pigeon)*. IP over Avian Carriers was initially described in *[****RFC 1149****](https://tools.ietf.org/html/rfc1149)*, issued by the *[*Internet Engineering Task Force*](https://en.wikipedia.org/wiki/Internet_Engineering_Task_Force)* (IETF) written by D. Waitzman and released on April 1, 1990.*

*IPoAC has been successfully implemented, but for only nine packets of data, with a *[*packet loss*](https://en.wikipedia.org/wiki/Packet_loss)* ratio of 55% (due to user error),*<span id="anchor-11"></span>[*\[2\]*](https://en.wikipedia.org/wiki/IP_over_Avian_Carriers#cite_note-2)* and a *[*response time*](https://en.wikipedia.org/wiki/Response_time_%28telecommunications%29)* ranging from 3000 seconds (~54 minutes) to over 6000 seconds (~1.77 hours). Thus, this technology suffers from poor *[*latency*](https://en.wikipedia.org/wiki/Latency_%28engineering%29)*. Nevertheless, for large transfers, avian carriers are capable of high average throughput when carrying flash memory devices, effectively implementing a *[*sneakernet*](https://en.wikipedia.org/wiki/Sneakernet)*. During the last 20 years, the information density of storage media and thus the bandwidth of an avian carrier has increased 3 times as fast as the bandwidth of the Internet.*<span id="anchor-12"></span>[*\[3\]*](https://en.wikipedia.org/wiki/IP_over_Avian_Carriers#cite_note-3)* IPoAC may achieve bandwidth peaks of orders of magnitude more than the Internet when used with multiple avian carriers in rural areas. For example: If 16 homing pigeons are given eight 512 GB SD cards each, and take an hour to reach their destination, the throughput of the transfer would be 145.6 Gbit/s, excluding transfer to and from the SD cards.*

https://en.wikipedia.org/wiki/IP\_over\_Avian\_Carriers

## <span id="anchor-13"></span><span id="IPStack"></span>IP Stack

|                  |
|------------------|
| Application      |
| Transport        |
| Internet/Network |
| Data Link/Link   |
| Physical         |

Table 1: IP Stack
