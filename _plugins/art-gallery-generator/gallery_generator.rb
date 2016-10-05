include FileUtils

module Jekyll
	class FilePage < Page
		# An image page
		def initialize(site, base, dir, album_source, img_source, name, prev_name, next_name, album_page)
                        puts "Entering ImagePage:initialize()"
			@site = site
			@base = base
			@dir = dir
                        @dir = album_source
			@name = name # Name of the generated page

puts "loading file data....."
			local_config = {}
			['yml', 'yaml'].each do |ext|
				config_file = "#{img_source}.yml"
				if File.exists? config_file
					local_config = YAML.load_file(config_file)
				end
			end
puts local_config
puts "finshed"

			self.process(@name)
			self.read_yaml(File.join(@base, '_layouts'), 'image_page.html')





#self.data['albums'] = { 'title' => subalbum, 'url' => albumpage.url, 'image' => albumpage.data['image'], 'description' => albumpage.data['description'], 'hidden' => albumpage.data['hidden'] }
#self.data['files'].push( filedata )


      self.data = {
			'title' => "#{File.basename(img_source)}",
                                'author' => local_config['author'] || "unknown",
                                'website' => local_config['website'] || "unknown",
                                'settings' => local_config['settings'] || {'still-image'=>'true','360'=>'false','deepzoom'=>'false','x3dom'=>'false'},
			'img_src' => img_source,
			'prev_url' => prev_name,
			'next_url' => next_name,
			'album_url' => album_page,
                       # 'url' => File.join('/', @dir, @dir, @name)
 }
filedata = {'title'=>self.data['title'],'author'=>self.data['author'],'website'=>self.data['website'],'settings'=>self.data['settings']}

                               # self.data['files'] = @album_metadata['files'] || []
puts self.data
puts "writing file data....."
File.open("#{img_source}.yml", "w") do |f|
      f.write(filedata.to_yaml)
    end
puts "finshed"
                        puts "Leaving ImagePage:initialize()"
		end

	end

	class DeepZoomPage < Page
		# An DeepZoom page
		def initialize(site, base, dir, album_source, img_source, name, prev_name, next_name, album_page)
                        puts "Entering DeepZoomPage:initialize()"
			@site = site
			@base = base
			@dir = dir
                        @dir = dir
			@name = name # Name of the generated page
			self.process(@name)
			self.read_yaml(File.join(@base, '_layouts'), 'Deepzom_page.html')
      self.data = {
			'title' => "#{File.basename(img_source)}",
			'img_src' => img_source,
			'prev_url' => prev_name,
			'next_url' => next_name,
			'album_url' => album_page,
                        #'url' => File.join('/', @dir, @dir, @name)
 }

                        puts "Leaving DeepZoomPage:initialize()"
		end

	end

	class AlbumPage < Page
		# An album page

		DEFAULT_METADATA = {
			'sort' => 'filename asc',
			'paginate' => 50,
		}

		def initialize(site, base, dir, page=0)
puts "Entering AlbumPage:initialize()"

    @dir = dir.gsub(/^_/, "").gsub(/[^0-9A-Za-z.\\\-\/]/, '_')   # destination dir, same as source sans the leading underscore, the directory component is made web compatible
    FileUtils.mkdir_p(site.in_dest_dir(@dir), :mode => 0755)
			@site = site
			@base = base # Absolute path to use to find files for generation

			# Page will be created at www.mysite.com/#{album_source}/#{dir}/#{name}
			@name = album_name_from_page(page)
			@album_metadata = get_album_metadata
			self.process(@name)
			self.read_yaml(File.join(@base, '_layouts'), 'album_index.html')

	self.data['title'] = @album_metadata['title'] || @dir
 #self.data['title'] = @dir
                      #  self.data['url'] = File.join(@dir, @name)
			self.data['files'] = []
                        @base_album_path = site.config['album_dir'] || 'albums'

puts "#{@dir}.png"
				if File.exists? "#{@dir}.png"
puts "found you"
					self.data['image'] = File.join("#{@dir}.png")
				end
			self.data['image'] = self.data['image'] || File.join(@base_album_path, "./blank_folder.png")

			self.data['albums'] =  []
			self.data['description'] = @album_metadata['description'] || ""
			self.data['hidden'] = true if @album_metadata['hidden']
			files, directories = list_album_contents

			# puts "Pagination"
			num_images = @album_metadata['paginate']
			if num_images
				first = num_images * page
				last = num_images * page + num_images
				self.data['prev_url'] = album_name_from_page(page-1) if page > 0
				self.data['next_url'] = album_name_from_page(page+1) if last < files.length
			end
			if page == 0
				directories.each do |subalbum|

puts File.join(@dir, subalbum)

					albumpage = AlbumPage.new(site, site.source, File.join(@dir, subalbum))
puts albumpage.data
					if !albumpage.data['hidden']
						self.data['albums'] << { 'title' => subalbum, 'url' => albumpage.url, 'image' => albumpage.data['image'], 'description' => albumpage.data['description'], 'hidden' => albumpage.data['hidden'] }
					end
					site.pages << albumpage #FIXME: sub albums are getting included in my gallery index
				end
			end
			files.each_with_index do |filename, idx|
				if num_images
					next if idx < first
					if idx >= last
						site.pages << AlbumPage.new(site, base, dir, page + 1)
						break
					end
				end
				prev_file = files[idx-1] unless idx == 0
				next_file = files[idx+1] || nil

				album_page = "#{@dir}/#{album_name_from_page(page)}"
				do_file(site, filename, prev_file, next_file, album_page)
			end

@album_metadata = self.data
#@album_metadata['title'] = @album_metadata['title'] || @dir
@album_metadata['author'] = ''
@album_metadata['website'] = ''
@album_metadata['settings'] = ''
puts @album_metadata
tmp = write_album_metadata
 puts "Leaving AlbumPage:initialize()"

		end

		def get_album_metadata
                        puts "Entering get_album_metadata()"
			site_metadata = @site.config['album_config'] || {}
			local_config = {}
			['yml', 'yaml'].each do |ext|
				config_file = File.join(@dir, 'album_info.yml')
				if File.exists? config_file
					local_config = YAML.load_file(config_file)
				end
			end
			return DEFAULT_METADATA.merge(site_metadata).merge(local_config)
puts DEFAULT_METADATA
 puts "Leaving get_album_metadata()"
		end

	def write_album_metadata
                        puts "Entering write_album_metadata()"
File.open(File.join(@dir, 'album_info.yml'), "w") do |f|
      f.write(@album_metadata.to_yaml)
    end
 puts "Leaving write_album_metadata()"
		end


		def album_name_from_page(page)
                        puts "Entering album_name_from_page()"
			return page == 0 ? 'index.html' : "index#{page + 1}.html"
 puts "Leaving album_name_from_page()"
		end

		def list_album_contents
                        puts "Entering list_album_contents()"
			entries = Dir.entries(@dir)
			entries.reject! { |x| x =~ /^\./ } # Filter out ., .., and dotfiles

			files = entries.reject { |x| File.directory? File.join(@dir, x) } # Filter out directories

			directories = entries.select { |x| File.directory? File.join(@dir, x) } # Filter out non-directories
			files.select! { |x| ['.png', '.jpg','.jpeg', '.gif','.pov.tgz','.schematic'].include? File.extname(File.join(@dir, x)) } # Filter out files that image-tag doesn't handle
			# Sort images
			def filename_sort(a, b, reverse)
				if reverse =~ /^desc/
					return b <=> a
				end
				return a <=> b
			end

			sort_on, sort_direction = @album_metadata['sort'].split
			files.sort! { |a, b| send("#{sort_on}_sort", a, b, sort_direction) }
puts files
puts directories
			return files, directories
 puts "Leaving list_album_contents()"
		end

		def do_file(site, filename, prev_file, next_file, album_page)
                        puts "Entering do_file()"
puts filename

			#return DEFAULT_METADATA.merge(site_metadata).merge(local_config)
			# Get info for the album page and make the image's page.

			rel_link = file_page_url(filename)
			file_source = "#{File.join(@dir, filename)}"




			# Create image page
			site.pages << FilePage.new(@site, @base, @dir, @dir, file_source,
				rel_link, file_page_url(prev_file), file_page_url(next_file), album_page)

 puts "Leaving do_file()"
		end

		def file_page_url(filename)
                        puts "Entering file_page_url()"
puts "filename:"
puts filename
			return nil if filename == nil
			ext = File.extname(filename)
			return "#{File.basename(filename, ext)}_#{File.extname(filename)[1..-1]}.html"
 puts "Leaving file_page_url()"
		end
	end

	class GalleryGenerator < Generator
		safe true

		def generate(site)
                        puts "Entering GalleryGenerator:generate()"
    dir = site.config["source_dir"] || "_photos"
				base_album_path = site.config['album_dir'] || 'albums'
    original_dir = Dir.getwd

    # generate galleries
    Dir.chdir(site.source)
    begin
site.pages << AlbumPage.new(site, site.source, dir)
 #     Dir.foreach(dir) do |base_album_path|
 #       gallery_path = File.join(dir, base_album_path)
 #       if File.directory?(gallery_path) and base_album_path.chars.first != "." # skip galleries starting with a dot
#puts gallery_path
#					site.pages << AlbumPage.new(site, site.source, gallery_path)

       #   gallery = GalleryPage.new(site, site.source, gallery_path, gallery_dir)
       #   gallery.render(site.layouts, site.site_payload)
       #   gallery.write(site.dest)
       #   site.pages << gallery
       #   galleries << gallery
#        end
 #     end
    rescue Exception => e
      puts "Error generating galleries: #{e}"
      puts e.backtrace
    end

    Dir.chdir(original_dir)


                        puts "Leaving GalleryGenerator:generate()"
		end
	end
Jekyll::Hooks.trigger :pages, :post_init, self
end