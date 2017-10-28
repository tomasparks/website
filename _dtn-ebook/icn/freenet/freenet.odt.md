## FreeNet

-   15 years of research and practical use in the real world
-   Freenet is routing algorithm works a bit like DHT network

<!-- -->

### <span id="anchor"></span>Papers

-   Freenet White paper \[freenetWP\]
-   Freenet: A Distributed Anonymous Information Storage and Retrieval System \[FreenetDAISRS\]
-   Protecting Free Expression Online with Freenet \[FIOFreenet\]

### <span id="anchor-1"></span>Freenet keys

#### <span id="anchor-2"></span>Content Hash Keys

*Content Hash Keys are for files with static content. These keys are hashes of the content of the file. A CHK uniquely identifies a file, it should not be possible for two files with different content to have the same CHK. The CHK consists of three parts:*

1.  *the hash for the file *
2.  *the decryption key that unlocks the file, and *
3.  *the cryptographic settings used *

#### <span id="anchor-3"></span>Signed Subspace Keys

*Signed Subspace Keys are usually for sites that are going to change over time.It works by using public-key cryptography so you can sign your site. Only the person with the secret key can add updated versions of your site to Freenet.*

#### <span id="anchor-4"></span>Updateable Subspace Keys

*Updateable Subspace Keys are useful for linking to the latest version of a Signed Subspace Key (SSK) site. Note that USKs are really just a user-friendly wrapper around SSKs, which hide the process of searching for more recent versions of a site.*

#### <span id="anchor-5"></span>Keyword Signed Keys

*Keyword-Signed Keys (KSKs) allow you to save named pages in Freenet. They are not secure against spamming or name hijacking. Several people could each insert a different file to Freenet, all with the same address. However, there is a collision detection, which tries to prevent overwriting of a once-inserted page. *

****NOT****** used**

****
