require 'rubygems'
require 'net/https'
require 'uri'
require 'json'
require 'yaml/store'
require 'jekyll'

desc "Update CDNjs Libraries"
task :updatecdnjs do
	site = Jekyll.configuration({})
	cdnjsFile = site['source'] + '/' + site['data_source'] + '/cdnjs.yml'

	puts 'Fetching current CDNjs libraries...'

  cdnjs_current = Net::HTTP.get(URI.parse('http://cdnjs.com/packages.min.json'))
	cdnjs = JSON.parse(cdnjs_current)

	File.delete(cdnjsFile) if File.exist?(cdnjsFile)

	cdnjsYaml = YAML::Store.new(cdnjsFile)
  cdnjsYaml.transaction do

		cdnjs['packages'].each do |package|
			cdnjsYaml[package['name'].to_s] = '//cdnjs.cloudflare.com/ajax/libs/'+ package['name'].to_s + '/' + package['version'].to_s + '/' + package['filename'].to_s
		end

	end
end
