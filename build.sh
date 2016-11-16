calibredb catalog /home/tom/blog/_data/ebooks.csv --sort-by title_sort --fields=author_sort,authors,title_sort,title,isbn,pubdate,publisher,series,series_index,#website --verbose

bundle update



rsync -r --progress --prune-empty-dirs  \
 --include "*.html" \
 --include "*.md" \
 --include "feed.xml" \
 --include "sitemap.xml" \
 --include "robot.txt" \
 --include "*.css" \
 --include "*.scss" \
 --include "*.eot" \
 --include "*.otf" \
 --include "*.svg" \
 --include "*.ttf" \
 --include "*.woff" \
 --include "*.js" \
 --include "*.png" \
 --include "_layouts/" \
 --include "_includes/" \
 --include "website/" \
 --include "assets/" \
 --include "assets/css/" \
 --include "assets/css/fonts/" \
 --include "assets/css/Glass_TTY_VT220/" \
 --include "assets/css/Glass_TTY_VT220/fonts/" \
 --include "assets/js/" \
 --include "assets/img/" \
 --include "assets/ext/" \
 --include "assets/ext/Imager.js/" \
 --include "assets/ext/jquery*/" \
 --exclude "*" \
 --exclude "README.md" \
 . theme/


cd theme

git add --all 
git commit -a -m "updating theme."
git push

cd ..


jekyll build --verbose --trace

cp -r -f ./assets/img/resized/* ./_site/assets/img/resized/


git add --all 
git commit -a -m "updating website source code."
git push

cd _site
git add --all 
git commit -a -m "updating static website."
git push


#wget --spider -r --delete-after -P "/tmp/" -e robots=off https://tomasparks.github.io/


