# Networks Types

The are two network types *DB-based* and *flooding-based*, they both have advantages and disadvantageous.

DB-based:

-   Batman \[BATMAN\] (mesh)
-   Prophet \[PRoPHET\] (DTN)

Flooding-based:

-   AODV routing \[AODV\] [1] (mesh)
-   Epidemic routing (DTN)

DB-based advantages:

-   efficient routing

DB-based disadvantages:

-   Bandwidth for routing DB sharing
-   DB Storage[2]
-   processing time of routing DB (updating entrys, removing entrys, sorting)[3]

Flooding-based advantages:

-   on-demand routing tables

Flooding-based disadvantages:

-   Bandwidth for user data
-   Storage for user data (DTN)
-   bad/wasteful routing

[1] AODV routing is not a true flood-based network, the algorithm floods the network to find a path to the destination, then send the user data along that path.

[2] See <https://en.wikipedia.org/wiki/Border_Gateway_Protocol#Routing_table_growth> and <https://en.wikipedia.org/wiki/FidoNet#Nets_and_nodes>

[3] We have not seen this issue in wireless mesh networks because radio bandwidth makes the networks unusable before we hit this issue and DTN networks have been too small. People who run wireless mesh network keep adding radio to keep the network functioning as it growing larger and larger
