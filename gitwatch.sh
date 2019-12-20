cd ~/github/website/sources/ebooks-src
gitwatch.sh -r origin . &
cd ~/github/website/sources/Articles
gitwatch.sh -s 60 -r origin  . &
cd ~/github/website/sources
gitwatch.sh -r origin . &
cd ~/github/website/sources/miniatures-src
gitwatch.sh -r origin . &
