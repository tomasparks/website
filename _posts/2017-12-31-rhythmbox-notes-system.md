---
layout: post
title:  "Rhythmbox scrobbling notes system"
date:   2017-12-31
icons: indieweb, scrobble, scrobbling, music, notes, note
---

I've just written [Rhythmbox](https://en.wikipedia.org/wiki/Rhythmbox) scrobbling system for my notes

the php script takes rhythmdb.xml located at /home/tom/.local/share/rhythmbox/ and creates a yml file

{% github_sample_ref /tomasparks/website/master/_notes/local/2017/r12.yml 0 4 %}
{% highlight yaml %}
{% github_sample /tomasparks/website/master/_rake/_notes/local/2017/r12.yml 0 4 %}
{% endhighlight %}

### Source Code ###

{% github_sample_ref /tomasparks/website/c2215b2476f200f4e8d289fa55268b716cad07a9/_rake/rhythmdb2notes.php %}
{% highlight php %}
{% github_sample /tomasparks/website/c2215b2476f200f4e8d289fa55268b716cad07a9/_rake/rhythmdb2notes.php %}
{% endhighlight %}

i've updated and cleaned notes.php

{% github_sample_ref /tomasparks/website/master/_rake/notes.php %}
{% highlight php %}
{% github_sample /tomasparks/website/master/_rake/notes.php %}
{% endhighlight %}

