git clone https://#{ENV['GITHUB_API_KEY']}@github.com/#{USERNAME}/Dynix-theme-jekyll.git _theme
cd _theme
git submodule update --init --recursive
cd ..

rsync -I -r --progress --prune-empty-dirs -vv  --remove-source-files \
 --exclude ".git/" \
  --exclude "_theme/" \
 . _theme/
 

rsync -I -r --progress --prune-empty-dirs -vv  --remove-source-files \
 --exclude ".git/" \
  --exclude "_theme/" \
_theme/  .

jekyll build --config _config.yml --verbose --trace --profile
