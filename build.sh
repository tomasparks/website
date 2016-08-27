

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

mkdir -p "../compressed/tomasparks.github.io/"
cd archive
find -mindepth 1 -type d  -exec mkdir -p "../../compressed/tomasparks.github.io/archive/{}" \;
find -mindepth 1 -type d  -exec zpaq a "../../compressed/tomasparks.github.io/archive/{}/????.zpaq" "{}" -test -all \;
cd ..

zpaq a "../compressed/tomasparks.github.io/"$(date +%F)".zpaq" * -not "archive" -test -all -index "../compressed/tomasparks.github.io/index.zpaq"
