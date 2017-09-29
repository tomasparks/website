---
title: camera network
date: 18-06-11
---
~~~~~~~
[dtn-interest] Visual Sensor Network

Tom Sparks <tom_a_sparks@yahoo.com.au> Sat, 18 June 2011 09:19 UTC

I am looking at setting up a Visual Sensor Network to take photographs of lighhtning and other weather (towns name sake)

the node must use energy harvesting methods only
I am not looking at live video feeds

I think I have found the brains for the node (pandaboard or Beagleboard), but they has too much extra junk or are missing key features

I am looking for other options
needs: 
* usb port for webcam
* Wifi
* port for hard drive

we have 4 tours bus routes I can use as data mules, but I don't want to use them until there are have enough nodes on the bus's routes

I am wondering if there are any papers I can use to base this project on?

the closest paper to this project is Panoptes: Scalable Low-Power Video Sensor Networking Technologies

--
tom_a_sparks "It's a nerdy thing I like to do"
Please use ISO approved file formats excluding Office Open XML - http://www.gnu.org/philosophy/no-word-attachments.html
3 x (x)Ubuntu 10.04, Amiga A1200 WB 3.1, UAE AF 2006 WB 3.X, Sam440 AOS 4.1
~~~~~~~
~~~~~~~
Re: [dtn-interest] Visual Sensor Network

ashish makani <ashish.makani@gmail.com> Sat, 18 June 2011 09:54 UTC

The following papers came to mind :

1.* SensEye: a multi-tier camera sensor network*
http://portal.acm.org/citation.cfm?id=1101191

2. Irisnet: An architecture for a worldwide sensor
web<http://www.computer.org/portal/web/csdl/doi/10.1109/MPRV.2003.1251166>
http://www.pittsburgh.intel-research.net/people/gibbons/papers/NDGS02.pdf

3. A Survey of Visual Sensor Networks
http://www.hindawi.com/journals/am/2009/640386/

I havent looked at sensor networks in years, so may not be the most current

Best,
ashish


On Sat, Jun 18, 2011 at 2:19 AM, Tom Sparks <tom_a_sparks@yahoo.com.au>wrote:

> I am looking at setting up a Visual Sensor Network to take photographs of
> lighhtning and other weather (towns name sake)
>
> the node must use energy harvesting methods only
> I am not looking at live video feeds
>
> I think I have found the brains for the node (pandaboard or Beagleboard),
> but they has too much extra junk or are missing key features
>
> I am looking for other options
> needs:
> * usb port for webcam
> * Wifi
> * port for hard drive
>
> we have 4 tours bus routes I can use as data mules, but I don't want to use
> them until there are have enough nodes on the bus's routes
>
> I am wondering if there are any papers I can use to base this project on?
>
> the closest paper to this project is Panoptes: Scalable Low-Power Video
> Sensor Networking Technologies
>
> --
> tom_a_sparks "It's a nerdy thing I like to do"
> Please use ISO approved file formats excluding Office Open XML -
> http://www.gnu.org/philosophy/no-word-attachments.html
> 3 x (x)Ubuntu 10.04, Amiga A1200 WB 3.1, UAE AF 2006 WB 3.X, Sam440 AOS 4.1
> _______________________________________________
> dtn-interest mailing list
> dtn-interest@irtf.org
> https://www.irtf.org/mailman/listinfo/dtn-interest
>
~~~~~~~
~~~~~~~
Re: [dtn-interest] Visual Sensor Network

Tom Sparks <tom_a_sparks@yahoo.com.au> Sun, 19 June 2011 09:31 UTC

--- On Sat, 18/6/11, ashish makani <ashish.makani@gmail.com>; wrote:
>The following papers came to mind :

>1. SensEye: a multi-tier camera sensor network 
>http://portal.acm.org/citation.cfm?id=1101191

the SensEye setup is to complex

>2. Irisnet: An architecture for a worldwide sensor web

>http://www.pittsburgh.intel-research.net/people/gibbons/papers/NDGS02.pdf

nice idea for on-the-gird/network sensor nodes 

>3. A Survey of Visual Sensor Networks

>http://www.hindawi.com/journals/am/2009/640386/

i've been meaning to read this one 

>I havent looked at sensor networks in years, so may not be the most current

>Best,
>ashish

the more papers I read the more I keep going back to Panoptes paper[1]

but without "reinventing the wheel", I am looking at using motion[2] for camera control and DTN2 with prophet


[1] http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.84.9939&rep=rep1&type=pdf
[2] http://www.lavrsen.dk/foswiki/bin/view/Motion/WebHome

tom
~~~~~~~



* [beagleboard-xm](http://beagleboard.org/beagleboard-xm)
* [PandaBoard](https://en.wikipedia.org/wiki/PandaBoard)
* [Tutorial: Torch/Flashlight + Webcam = HD Timelapse System](http://www.digitalurban.org/2008/11/tutorial-torch-webcam-hd-timelapse.html)
* [The Australian Weathercam Network](http://weathercamnetwork.com.au/)