

 bundle update

jekyll build
htmlproofer ./_site


git add --all 
git commit -a -m "updating website"
git push

cd _site
git add --all 
git commit -a -m "updating website"
git push
