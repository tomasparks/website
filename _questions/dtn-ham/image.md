---
title: Image formates
layout: page
---
## The Question ##

I am looking for a Image formate that has the following features:

 * Incremental updates[^1]: / Progressive Transmission[^2]:
 * Roll-back
 * lossy and lossless support

## image formates ##

thes image formates may support what I am looking for:

 * MrSID
 * JPEG 2000
 * ECW (Enhanced Compression Wavelet)
 * BPE (BIT PLANE ENCODER)
 * ICER
 * Progressive Graphics File

NOTE: all Interlacing image formates are NOT suitable ( PNG/ADAM7, GIF, PJPG )


### MrSID ###

 * [URL](https://en.wikipedia.org/wiki/MrSID)
 * no open-source code :(
 * no usefully information :(
 * Has patented by LizardTech 
 * Originated as the result of research efforts at Los Alamos National Laboratory (LANL).

### JPEG 2000 ###

 * [URl](https://en.wikipedia.org/wiki/JPEG_2000)

### ECW (Enhanced Compression Wavelet) ###

 * [URL](https://en.wikipedia.org/wiki/ECW_(file_format))
 * Has patents, see US 6201897 and US 6442298.

### BPE (BIT PLANE ENCODER) ###

 * [CCSDS 120.1-G-2 GREEN BOOK](http://public.ccsds.org/publications/archive/120x1g2.pdf) February 2015
 * [CCSDS 122.0-B-1 BLUE BOOK](http://public.ccsds.org/publications/archive/122x0b1c3.pdf) November 2005
 * [The New CCSDS Image Compression Recommendation](http://public.ccsds.org/publications/documents/IEEE_2005BigSky_PaperF1165_final.pdf)
 * [Source code](http://hyperspectral.unl.edu/)
 * cant build source code, has demo on website

### ICER ###

 * [The ICER Progressive Wavelet Image Compressor](http://ipnpr.jpl.nasa.gov/progress_report/42-155/155J.pdf)
 * cant find source code :(

### Progressive Graphics File ###

 * [Website](http://www.libpgf.org/)
 * looks like the best file formate
 * but the source code is unbuildable :(

## Results ##
None[^3]:


[^1]: 
> An incremental backup is one that provides a backup of files that have changed or are new since the last backup;
> it is one that backs up only the data that have changed since the last backup — be it a full or incremental backup.
> An incremental backup is a backup of latest changes since the last backup (any level) so that when a full recovery is needed the restoration process would need the last full backup plus all the incremental backups until the point-in-time of the restoration.[5] Incremental backups are often desirable as they consume minimum storage space and are quicker to perform than differential backups.[6] The purpose of an incremental backup is to preserve and protect data by creating copies that are based on the differences in those data and thus minimize the amount of time needed to perform the backup. With incremental backups, successive copies of the data contain only that portion that has changed since the preceding backup copy was made.
[source](https://en.wikipedia.org/wiki/Incremental_backup)
[^2]: 
> This implies that the bitstream is arranged so that most important information is near the front end of the bitstream and the least important information is at the back of the bitstream. Thus, in decoding, the quality of the decoded image is progressively increased.
[source](http://www.igi-global.com/dictionary/progressive-transmission/36015)
[Pyramid (image processing)](https://en.wikipedia.org/wiki/Pyramid_(image_processing) )
[^3]: NASA/CCSDS and PGF are the best options today
