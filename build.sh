

 bundle update

jekyll build --verbose --trace



git add --all 
git commit -a -m "updating website source code."
git push

cd _site
git add --all 
git commit -a -m "updating static website."
git push

htmlproofer ./_site
