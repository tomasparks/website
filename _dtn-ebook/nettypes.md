---
layout: ebook
title: Networks Types
---
# Networks Types #
The are two network types _DB-based_ and _flooding-based_, they both have advantages and disadvantageous.

DB-based:

  * Batman {% cite A.Neumann2008 --file altdtn %} (mesh)
  * Prophet {% cite A.Lindgren2012 --file altdtn %} (DTN)

Flooding-based:

  * AODV routing {% cite C.Perkins2003 --file altdtn %}[^1] (mesh)
  * Epidemic routing (DTN)

DB-based advantages:

* efficient routing 

DB-based disadvantages:

  * Bandwidth for routing DB sharing
  * DB Storage[^2]
  * processing time of routing DB (updating entrys, removing entrys, sorting)[^3]

Flooding-based advantages:

  * on-demand routing tables

Flooding-based disadvantages:

  * Bandwidth for user data
  * Storage for user data (DTN) 
  * bad/wasteful routing

Bibliography
{% bibliography --cited --file altdtn %}

[^1]: AODV routing is not a true flood-based network, the algorithm floods the network to find a path to the destination, then send the user data along that path.
[^2]: See <https://en.wikipedia.org/wiki/Border_Gateway_Protocol#Routing_table_growth> and <https://en.wikipedia.org/wiki/FidoNet#Nets_and_nodes>
[^3]: We have not seen this issue in wireless mesh networks because radio bandwidth makes the networks unusable before we hit this issue and DTN networks have been too small. People who run wireless mesh network keep adding radio to keep the network functioning as it growing larger and larger
