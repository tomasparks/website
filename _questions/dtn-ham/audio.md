---
title: Audio formates
layout: page
---
## The Question ##

I am looking for a Audio formate that has the following features:

 * Incremental updates[^1]: / Progressive Transmission[^2]:
 * Roll-back
 * lossy and lossless support

## Audio formates ##

thes Audio formates may support what I am looking for:

 * opus


NOTE:

### Opus ###

 * [Overview from wikipedia.org](https://en.wikipedia.org/wiki/Opus_(audio_format)) 
 * [Overview from hydrogenaudio](http://wiki.hydrogenaud.io/index.php?title=Opus)
 * [URL](https://opus-codec.org/)
 * Bitrates from 6 kb/s to 510 kb/s
 * Sampling rates from 8 kHz (narrowband) to 48 kHz (fullband)
 * Frame sizes from 2.5 ms to 60 ms
 * Support for both constant bitrate (CBR) and variable bitrate (VBR)
 * Audio bandwidth from narrowband to fullband
 * Support for speech and music
 * Support for mono and stereo
 * Support for up to 255 channels (multistream frames)
 * Dynamically adjustable bitrate, audio bandwidth, and frame size
 * Good loss robustness and packet loss concealment (PLC)
 * Floating point and fixed-point implementation
 * RFC 6716
 * Opus support is mandatory for WebRTC implementations. 
 * lossy only


## Results ##
None[^3]:


[^1]: 
> An incremental backup is one that provides a backup of files that have changed or are new since the last backup;
> it is one that backs up only the data that have changed since the last backup — be it a full or incremental backup.
> An incremental backup is a backup of latest changes since the last backup (any level) so that when a full recovery is needed the restoration process would need the last full backup plus all the incremental backups until the point-in-time of the restoration.[5] Incremental backups are often desirable as they consume minimum storage space and are quicker to perform than differential backups.[6] The purpose of an incremental backup is to preserve and protect data by creating copies that are based on the differences in those data and thus minimize the amount of time needed to perform the backup. With incremental backups, successive copies of the data contain only that portion that has changed since the preceding backup copy was made.
[source](https://en.wikipedia.org/wiki/Incremental_backup)
[^2]: 
> This implies that the bitstream is arranged so that most important information is near the front end of the bitstream and the least important information is at the back of the bitstream.
[source](http://www.igi-global.com/dictionary/progressive-transmission/36015)   
[^3]: 
> Question need to asked on the opus mailing list: Could opus support Incremental updates and/or Progressive Transmission?
> the Bitrate scalability demo makes me think it is possible
