---
title: POPBuffer test crytek-sponza
date: 11-11-2016
categories: X
spin-off: X
spin-off-from: retrospacegame
merge-to: retrospacegame
---

> i've been testing pop-buffer with meshes from <http://graphics.cs.williams.edu/data/meshes.xml>
>
>* Used blender to convert the obj/mtl files to x3d
>
>Issues:
>* source meshes have no geometry instancing, manual geometry instancing too slow :(
>* no priority loading in X3DOM
>* loading hidden submeshes (need a better LODer)
>
>Bugs?:
>* pop-buffer boundary box seams too big for submeshes
bug with APOT cant fix close source
>
>
>test: <https://tomasparks.github.io/X3D/popbuffers/crytek-sponza/index.html>

{% reference Limper2013 --file 3D_graphics %}
