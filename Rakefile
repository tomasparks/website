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
    sh "git clone https://#{ENV['GIT_NAME']}:#{ENV['GH_TOKEN']}@github.com/#{USERNAME}/#{DEST_REPO}.git #{CONFIG["destination"]}"
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
    sh "git clone https://github.com/tomasparks/Dynix-theme-jekyll.git _theme"
    sh "echo WTF1"
    sh "diff --help"
    sh "diff --recursive  ./_theme/ .  > #{tmp}/build-precopy-diff.txt [$$? -eq 1]"
    Dir.chdir("_theme") { sh "cp -n -r * ../" }
    #sh "cd _theme"
    #sh "cp -n -r * ../"
    #sh "cd .."
    sh "ls"
    sh "patch -p0 --unified --batch --verbose < #{tmp}/build-precopy-diff.txt"
    sh "patch -p0 --unified --batch --verbose < #{tmp}/build-precopy-diff.txt"


    sh "git checkout #{SOURCE_BRANCH}"
    Dir.chdir(CONFIG["destination"]) { sh "git checkout #{DESTINATION_BRANCH}" }

    # Generate the site
    sh "bundle exec jekyll build --config base.yml,_config.yml,responsive_image.yml,scholar.yml,webmentions.yml --verbose --trace --profile"
    sh "bundle exec jekyll webmention"

    # Commit and push to github
    sha = `git log`.match(/[a-z0-9]{40}/)[0]
    Dir.chdir(CONFIG["destination"]) do
      sh "git add --all ."
      sh "git commit -m 'Updating to #{USERNAME}/#{REPO}@#{sha}.'"
      sh "git push --quiet origin #{DESTINATION_BRANCH}"
      puts "Pushed updated branch #{DESTINATION_BRANCH} to GitHub Pages"
    end
  end
end
end
