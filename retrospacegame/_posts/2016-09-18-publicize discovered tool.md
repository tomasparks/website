---
title: publicize discovered tool
categories: minecraft
date: 2016-09-18
status: active
image: minecraft-project-2016-09-18.png
---
~~~~~~~
SUBJECT: [x3d-public] minecraft to X3dom
FROM: tom sparks tom_a_sparks at yahoo.com.au
Sun Sep 18 09:41:28 PDT 2016

I have been developing a toolchain that can convert a minecraft 
schematic[1] file to X3D

tools:
* blockmodel[2]
* aopt
missing a lightmap generator[3]

example https://tomasparks.github.io/temp/minecraft2x3d/test_x3d.html

bugs:
camera not set (click: Show everything)
texture seams
missing transparency
missing sky


[1] http://minecraft.gamepedia.com/Schematic_file_format
[2] https://github.com/paulharter/blockmodel
[3] looking at using blender, but I have not found a automated way of 
doing lightmapping :(

~~~~~~~

source: http://web3d.org/pipermail/x3d-public_web3d.org/2016-September/005211.html

~~~~~~~
SUBJECT: Re: [x3d-public] minecraft to X3dom
Don Brutzman brutzman at nps.edu
Fri Sep 30 08:23:47 PDT 2016

Tom this really looks great!  Screenshot image attached.  8)

Please advise if further questions might help your effort, and whether you think your converter might be listed under X3D Resources.

Tweeted at
https://twitter.com/Web3DConsortium/status/781876960553152512

On 9/18/2016 9:41 AM, tom sparks wrote:
> I have been developing a toolchain that can convert a minecraft schematic[1] file to X3D
>
> tools:
> * blockmodel[2]
> * aopt
> missing a lightmap generator[3]
>
> example https://tomasparks.github.io/temp/minecraft2x3d/test_x3d.html
>
> bugs:
> camera not set (click: Show everything)
> texture seams
> missing transparency
> missing sky
>
>
> [1] http://minecraft.gamepedia.com/Schematic_file_format
> [2] https://github.com/paulharter/blockmodel
> [3] looking at using blender, but I have not found a automated way of doing lightmapping :(



all the best, Don
-- 
Don Brutzman  Naval Postgraduate School, Code USW/Br       brutzman at nps.edu
Watkins 270,  MOVES Institute, Monterey CA 93943-5000 USA   +1.831.656.2149
X3D graphics, virtual worlds, navy robotics http://faculty.nps.edu/brutzman

-------------- next part --------------
A non-text attachment was scrubbed...
Name: MinecraftX3domLivingFountain.png
Type: image/png
Size: 531702 bytes
Desc: not available
URL: <http://web3d.org/pipermail/x3d-public_web3d.org/attachments/20160930/612ea5a8/attachment-0001.png>

~~~~~~~
source: http://web3d.org/pipermail/x3d-public_web3d.org/2016-September/005242.html
