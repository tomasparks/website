

 bundle update

jekyll build --verbose --trace

cp -r -f ./assets/img/resized/* ./_site/assets/img/resized/


git add --all 
git commit -a -m "updating website source code."
git push

cd _site
git add --all 
git commit -a -m "updating static website."
git push

htmlproofer https://tomasparks.github.io/

zpaq a "../compressed/tomasparks.github.io/????.zpaq" * -test -all
