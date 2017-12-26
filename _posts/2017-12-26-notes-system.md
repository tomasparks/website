---
layout: post
title:  "custom indieweb note system"
date:   2017-12-26
icons: indieweb
---

I am curently writing a custom indieweb [note](https://indieweb.org/note) system for my webiste, my requirements are different to most/all indieweb implementation as I need three different way of creating notes Online, Browser and Offline

### Online / text-editor ###


{% github_sample_ref /tomasparks/website/master/_notes/local/2017/10.yml %}
{% highlight yaml %}
{% github_sample /tomasparks/website/master/_notes/local/2017/10.yml %}
{% endhighlight %}

### web Browser / mircopub ###

Unimplementated because I have not found a browser plugin/addon that support my wishlist[^2] yet, the closest i've found is omibrowser

### Offline / CSV ###

I use a PDA[^1], when I away from my computers, the PDA has good database software witch can export [CSV](https://en.wikipedia.org/wiki/Comma-separated_values) files

{% github_sample_ref /tomasparks/website/master/_notes/pda/2017/12.csv %}
{% highlight csv %}
{% github_sample /tomasparks/website/master/_notes/pda/2017/12.csv %}
{% endhighlight %}

### Source Code ###

{% github_sample_ref /tomasparks/website/master/_rake/notes.php %}
{% highlight php %}
{% github_sample /tomasparks/website/master/_rake/notes.php %}
{% endhighlight %}

[^1]: It's as psion 5mx Pro
[^2]: Support like/fav
