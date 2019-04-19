# Caches
cache = File.join(Dir.pwd, '.jekyll-cache')
FileUtils.mkdir_p( cache )
cache_all_webmentions = "#{cache}/webmentions_io_outgoing.yml"
cache_sent_webmentions = "#{cache}/webmention_io_outgoing.yml"
cache_received_webmentions = "#{cache}/webmention_io_received.yml"

# Use: rake webmention
desc "Trigger webmentions"
task :webmention do
sh "echo hello"
  if File.exists?(cache_all_webmentions)
        sh "echo cache_all_webmentions? OK"
    if File.exists?(cache_sent_webmentions)
            sh "echo cache_sent_webmentions? OK"
      sent_webmentions = open(cache_sent_webmentions) { |f| YAML.load(f) }
      sh "echo reading #{cache}/webmention_io_outgoing.yml"
    else
      sent_webmentions = {}
    end
    all_webmentions = open(cache_all_webmentions) { |f| YAML.load(f) }
    all_webmentions.each_pair do |source, targets|
      if ! sent_webmentions[source] or ! sent_webmentions[source].kind_of?(Array)
        sent_webmentions[source] = Array.new
      end
      targets.each do |target|
        if target and ! sent_webmentions[source].find_index( target )
          if target.index( "//" ) == 0
            target  = "http:#{target}"
          end
          endpoint = `curl -s --location "#{target}" | grep 'rel="webmention"'`
          if endpoint
            endpoint.scan(/href="([^"]+)"/) do |endpoint_url|
              endpoint_url = endpoint_url[0]
              puts "Sending webmention of #{source} to #{endpoint_url}"
              sh "curl -s -i -d \"source=#{source}&target=#{target}\" -o /dev/null #{endpoint_url}"
              # puts command
              system command
            end
            sent_webmentions[source].push( target )
          end
        end
      end
    end
    File.open(cache_sent_webmentions, 'w') { |f| YAML.dump(sent_webmentions, f) }
  end
end
