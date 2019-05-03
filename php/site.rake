#############################################################################
#
# Modified version of jekyllrb Rakefile
# https://github.com/jekyll/jekyll/blob/master/Rakefile
#
#############################################################################

require 'rake'
require 'date'
require 'yaml'
require "tmpdir"

CONFIG = YAML.load(File.read('_config.yml'))
USERNAME = CONFIG["username"] || ENV['GIT_NAME']
REPO = CONFIG["repo"]
DEST_REPO = CONFIG["dest_repo"]
SOURCE_BRANCH = CONFIG['repo_branch']
DESTINATION_BRANCH = CONFIG['dest_branch']
# Determine source and destination branch
# User or organization: source -> master
# Project: master -> gh-pages
# Name of source branch for user/organization defaults to "source"
#if REPO == "#{USERNAME}.github.io"
#  SOURCE_BRANCH = CONFIG['branch'] || "source"
#  DESTINATION_BRANCH = "master"
#else
#  SOURCE_BRANCH = "master"
#  DESTINATION_BRANCH = "gh-pages"
# end

#############################################################################
#
# Helper functions
#
#############################################################################

def check_destination
  unless Dir.exist? CONFIG["destination"]
    sh "git clone https://#{ENV['GITHUB_API_KEY']}@github.com/#{USERNAME}/#{DEST_REPO}.git #{CONFIG["destination"]}"
  end
end

#############################################################################
#
# Post and page tasks
#
#############################################################################
#############################################################################
#
# Site tasks
#
#############################################################################
namespace :site do
  desc "Generate the site and push changes to remote origin"
  task :deploy do
    # Detect pull request
    if ENV['TRAVIS_PULL_REQUEST'].to_s.to_i > 0
      puts 'Pull request detected. Not proceeding with deploy.'
      exit
    end

    # Configure git if this is run in Travis CI
    if ENV["TRAVIS"]
      sh "git config --global user.name '#{ENV['GIT_NAME']}'"
      sh "git config --global user.email '#{ENV['GIT_EMAIL']}'"
      sh "git config --global push.default simple"
    end

     # Make sure destination folder exists as git repo
    check_destination
    Dir.mktmpdir do |tmp|
    sh "git clone https://#{ENV['GITHUB_API_KEY']}@github.com/#{USERNAME}/Dynix-theme-jekyll.git _theme" 
    Dir.chdir("_theme") { sh "git submodule update --init --recursive" }
    
    sh "rsync -I -r --prune-empty-dirs  --remove-source-files --exclude \".git/\" --exclude \"_site/\" --exclude \"_theme/\" . _theme/"
    sh "rsync -I -r --prune-empty-dirs  --remove-source-files --exclude \".git/\" --exclude \"_site/\" --exclude \"_theme/\" _theme/ ."


    sh "git checkout #{SOURCE_BRANCH}"
    Dir.chdir(CONFIG["destination"]) { sh "git checkout #{DESTINATION_BRANCH}" }

    # Generate the site
    sh "bundle exec jekyll build --config _config.yml --verbose --trace --profile"


    # Commit and push to github
    sha = `git log`.match(/[a-z0-9]{40}/)[0]
    Dir.chdir(CONFIG["destination"]) do
      sh "git config user.name 'Travis-CI'"
      sh "git config user.email 'noreply@travis-ci.org'"
      sh "git config push.default simple"
      sh "git config credential.helper \"store --file=.git/credentials\""
      sh "echo \"https://#{ENV['GITHUB_API_KEY']}:@github.com\" > .git/credentials"
      sh "git add --all ."
      sh "git commit -m 'Updating to #{USERNAME}/#{REPO}@#{sha}.'"
      sh "git push"
      puts "Pushed updated branch #{DESTINATION_BRANCH} to GitHub Pages"
    end
        sh "bundle exec jekyll webmention"
  end
end
end
