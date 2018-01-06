# PUB/SUB RFC

## 

The **DTN Pub/Sub Protocol** (DPSP) is a probabilistic multicast routing protocol for opportunistic networks. DPSP routers do not try to maintain a view of the network topology and select an optimal path. Instead, the routers replicate bundles to their neighbors in order to get the bundle delivered by multiple hops of store-carry-and-forward. Because bandwidth and storage are scarce resources, not all bundles can be copied to all neighbors. The resources have to be used efficiently to achieve the best possible user experience. For the selected use cases, two factors contribute to the user experience: increasing reliability, i.e., delivering as many subscribed bundles as possible, and reducing delay; these are the goals for DPSP routing. Since information bundles are exptected to be rather self-contained, constant delivery latency (low jitter) is not considered a critical requirement for the protocol.

Content is identified using a channel-based subscription system: interested users subscribe to channels and senders publish content by sending it as DTN bundles to the channel. Channels are identified by URIs which can be used as destination endpoint identifiers in the DTN bundle protocol. We assume that interested subscribers have ways to learn about services and channel URIs. This information could be distributed out- of-band — or over a dedicated, well-known DPSP channel, i.e., similar to the Session Announcement Protocol (SAP) for announcing IP multicast sessions. Content is transmitted in self-contained application data units, so that the receivers can process it when they receive the content even if the sender is not reachable at that time. Thus, senders and receivers are completely decoupled in terms of time and network topology.

Because of this decoupling, a source can publish new data at any time. A new channel does not need to be allocated in advance, it is created when something is published with a new channel URI. When an application publishes content, it passes the payload and the channel URI to its local bundle router. The router creates a new bundle and inserts it into the local storage.

## Subscribing

When a node decides to receive data from a certain channel, it issues a subscription. The subscription is independent from the sender and from the sending time at the sender. A node can even subscribe to a channel, before the first content is sent. Subscriptions are passed to all neighbors who build a list of active subscriptions which they forward to their neighbors. Thus, a subscription eventually propagates through the network. In addition to the channel URI, the entries of the subscription lists contain a subscription’s creation time, its lifetime, the number of hops from the original subscriber to the current node, and a unique identifier for the subscription so that duplicates can be detected.

## Publisher

## BLA BLA

We distinguish the following network entities:

-   sources that send bundles to channels
-   sinks that subscribe to channels
-   other nodes that are not interested in specific content bundles but store, carry and forward bundles and subscriptions for others. The number of entities of each type is not limited, there can be multiple sinks, sources and other nodes. Furthermore, a source can send bundles to different channels, but only a single source serves each channel.

The core DPSP operation is the exchange of subscriptions and bundles when two neighbors meet and then establish an opportunistic contact.

1.  When two nodes meet, they first exchange their subscription lists.
2.  Then each node builds a queue of bundles from the local storage to forward to the neighbor.
3.  There is one queue for each neighbor, even when a node has multiple contacts at the same time. The bundles in the queue are passed to filter functions that remove bundles whose probability to be delivered is not improved when they are replicated to the current neighbor.
4.  Then the nodes sort the bundles in their queues by their priorities.
5.  The bundle’s priority is calculated based on the utility of replicating it for increasing its delivery probability. After that, the routers start sending the bundles from the queues until the queues are empty or the contact breaks down.
6.  Routers do not only receive bundles for channels they subscribe to, but other bundles are distributed pro-actively as well in order to increase the probability of satisfying a subscription and to decrease the average time it takes to deliver bundles to interested sinks.

## 

## A. Selecting Bundles for Forwarding 

> DPSP is intended to optimize for reliability (delivery probability) and short delays. In order to use the scarce contact capacity efficiently to reach these goals, a bundle router needs to select those bundles that should be replicated to its neighbor .

> Unfortunately, reliability and minimum delay are sometimes contradictory goals so that a tradeoff is necessary. The forwarding criteria of DPSP allow for different priorities, so that a network can be configured to emphasize either reliability or short delays.

> For step 3 of the protocol sequence, we define a set of filters that remove bundles from the router queue, so that they are not even forwarded to the neighbor when the contact is long enough and has enough capacity to transmit all bundles in the queue. There are three filters which can be used in any combination: **Known Subscription Filter**, **Hop Count Filter**, and **Duplicate Filter**.

-   The **Duplicate Filter** removes bundles that the current neighbor has already received. A node’s subscription message provides information about which bundles the node has already seen before.
-   The **Known Subscription Filter** removes bundles for which neither the current node nor the current neighbor have seen a subscription. This filter avoids forwarding bundles nobody is interested in, but it also impedes the pro-active distribution of bundles.
-   The **Hop Count Filter** removes bundles if the neighbor’s corresponding subscription provides a higher hop count than the current node’s subscription. The intention of this filter is to prefer shorter delivery paths. The disadvantage of this filter is that it assumes a stable and symmetric path.

> For ordering bundles based on assigned priorities (step 4 of the protocol sequence), we define a set of heuristics to determine the priority of bundles. A heuristic is used to compare two bundles and determine their relative priority with respect to forwarding it to the current neighbor. The priority heuristics are named **Short Delay**, **Long Delay**, **Subscription Hop Count**, and **Popularity**.

> **Priority** heuristics can be combined with other priorities and with any combination of filters.

-   **Short Delay** compares bundles by their age (creation time) and prefers newer bundles, aiming at minimizing the delivery delay. The disadvantage here is that those subscribers who can only be reached by a long path from the sender are less likely to receive a bundle before it expires.
-   The **Long Delay** heuristic compares bundles by their age and prefers older bundles, so that all bundles are more likely to be delivered before they expire, even when their path is long. The disadvantage is, that the average delivery delay is likely to increase.
-   The **Subscription Hop Count** heuristic compares bundles by the hop count of the subscription to the bundle’s channel.
-   This **hop count **is a metric for the distance between the current neighbor and an original subscriber. The intention of this heuristic is to prefer forwarding bundles that are already close to their destination. This assumes that the path of the subscription and the path of the bundles are roughly similar in length. It does not mean the bundle needs to pass the same nodes as the subscription, but that the current node and the subscriber still have about the same number of hops between them. This is the case, for example, when nodes move around in groups.

<!-- -->

-   The **Popularity** heuristic compares bundles by the number of nodes subscribed to the bundle’s channel, i.e., the priority is based on channel’s popularity. When bundles for popular channels are assigned higher priorities, the total number of subscribers receiving bundles is likely to increase. On the other hand, the subscribers of unpopular channels will have a worse user experience, as many of their bundles are dropped along the way.

In this specific mobility scenario, we have seen that an algorithm such as preferring bundles with a more recent creation time (Short Delay), performs better with respect to delivery rates than any other tested algorithm or combination of algorithms. It also performs reasonably well with respect to delays. This is noteworthy since Short Delay does not consider any information about the network and subscribers’ interest. We ascribe these results to the following factors: 1) the mobility model does not provide enough stability over time, which increases the likelihood that knowledge about the network becomes inaccurate very fast. 2) When optimizing for a short average delivery delay, Flooding performs well due its aggressive replication approach, which seems to help to deliver bundles fast to a significant amount of subscribers. However, since some nodes are never reached due to inefficient resource utilization, Flooding must be considered sub-optimal with respect to fairness and reliability. As a take-away result, we can state that the applied algorithms should be carefully selected with respect to the network topology and the predominant mobility model.

## Refs:

Efficient Publish/Subscribe-based Multicast for Opportunistic Networking with Self-Organized Resource Utilization (epcMc4opsru.pdf)

A Socio-Aware Overlay for Publish/Subscribe Communication in Delay Tolerant Networks (Socio-Aware Overlay for PubSub Communication in Delay Tolerant Networks.pdf)
