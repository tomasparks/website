# <span id="Geo-Routing"></span>Geo-Routing

*As ad-hoc networks become more common, it is very likely that connectivity among the individual ad-hoc networks, as well as connectivity of any given ad-hoc network and the global Internet will be desired. Most likely this will require the introduction of hierarchies, as has been done in the Terminodes *\[snipped\]*. However, since the position of individual nodes in an ad-hoc network will change much more frequently than the position of the ad-hoc networks themselves, it could be argued that a hierarchical approach should use a location-based approach at the local level and topology-based routing over long distances and for Internet integration. It is also conceivable that a three level hierarchy could be used. At the lowest layer a proactive routing protocol could be employed to aggregate a small number of nodes and increase the robustness against positional errors. At the next layer a position based approach might be used that scales well to ad-hoc networks with numerous participants. Finally the third layer would use proactive or reactive approaches to connect the ad hoc networks with each other and with the global Internet.*

- \[posbmadhoc\]

I do agree with the authors thinking

## <span id="anchor"></span>Location Proxies

\[LocProxies\]

-   the underlying idea is sound, but the routing algorithm is a concern, this open up two questions

1.  How do the non-location-aware nodes learn their locations?

-   Flood-voting based?

1.  How do the location-aware node learn about the non-location-aware nodes?

-   DHT?

<!-- -->

-   I am think of two types of location proxies:

1.  Static
2.  Mobile

## <span id="anchor-1"></span>Locating Mobile Nodes with EASE: Learning Efficient Routes from Encounter Histories Alone

-   Nice idea but there is no information about getting the location
-   Simulation only

## <span id="anchor-2"></span>Distributed Location Management

\[VIMLOC\]

-   *tba*

## <span id="anchor-3"></span>Large Metropolitan-Scale Internetworks

-   A bit historic (1987/1988)[1]
-   has a congestion-control system
-   hierarchy organised
-   they were **predicting the future**:
-   router/gateways in every building
-   Mobile/Cell phone network
-   non-network-centric address
-   uses a Manhattan-style city
-   two level simulation based on the ARPANET (January 1986 geographic map with approximate latitude and longitude locations for each 48 IMP nodes)

### <span id="anchor-4"></span>HomeZone

-   Dtn support?
-   Is it too bandwidth costly?

## <span id="anchor-5"></span>Terminodes Routing

\[SOTNR\]

## <span id="anchor-6"></span>SubPos - A "Dataless" Wi-Fi Positioning System 

## <span id="anchor-7"></span>GeoHash

## <span id="anchor-8"></span>Geocasting

## <span id="anchor-9"></span>****Tahrir project****

[1] Why did we not go this route for city routing?
