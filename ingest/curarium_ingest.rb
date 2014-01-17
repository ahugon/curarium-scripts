class Curarium
	require 'net/http'
	require 'uri'
	
	# USAGE: ruby -r "./curarium_ingest.rb" -e "Curarium.ingest('PATH_TO_DIRECTORY', 'COLLECTION_INGEST_KEY')"
	# EXAMPLE, if running from ingest/ directory: 
	#          ruby -r "./curarium_ingest.rb" -e "Curarium.ingest('../output/json_output', 'COLLECTION_INGEST_KEY')"
	
	def self.ingest(path, key)
		
		# constant for URL
		base = "http://localhost:3000" #for ingesting to local site
		#base = "http://www.curarium.com" #for ingesting to live site
	
		print "Verifying that directory './#{path}' exists... "
		begin
			ent = Dir.entries("./#{path}")
			puts "confirmed!"
		rescue
			puts ""
			puts "ERROR: directory './#{path}' does not appear to exist!"
			return
		end
		
		puts "Found " + (ent.count - 2).to_s + " total files"
		
		print "Checking for collection corresponding to key '#{key}'... "
		
		# check whether key is the key of any existing collection
		response = Net::HTTP.post_form(URI.parse(base + "/collections/" + key + "/check_key"), {})

		if response.body.to_s.index("true").nil?
			puts ""
			puts "ERROR: key '#{key}' does not correspond to any existing Curarium collection!"
			return
		end	
		puts "confirmed!"
		
		j_count = 0
		ent.each do |f| 
			if !File.directory?(f) and File.extname(f).casecmp(".json").zero?
				filename = "./#{path}/#{File.basename(f)}"
				print "Processing #{(j_count + 1).to_s} of #{ent.count - 2}: #{filename}... "
				
				# extract json of this file's record
				rec_json = IO.read(filename)
				
				# send the record's json to server
				response = Net::HTTP.post_form(URI.parse(base + "/collections/" + key + "/ingest"), {"j" => rec_json})
				if !response.body.empty?
					j_count = j_count + 1
					puts "success!"
				end
			end
		end
		puts "Processed " + j_count.to_s + " JSON files (out of " + (ent.count - 2).to_s + " total files in directory)"
		puts "Done!"
	end
end