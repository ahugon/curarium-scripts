
<html>
	<head>
		<title>Extract Via Records</title>
	</head>
	<body>
		
		<?
		
			// for converting XML to JSON
			require("./lib/xmlParser.php");
			
			// helper function
			function startsWith($haystack, $needle)
			{
				return !strncmp($haystack, $needle, strlen($needle));
			}
			
			// helper function
			function endsWith($haystack, $needle)
			{
				$length = strlen($needle);
				if ($length == 0) {
					return true;
				}

				return (substr($haystack, -$length) === $needle);
			}
		
			/* for extracting records from VIA and creating .xml file for each: */
			/* Start by uncommenting this first block.  Then go to index.php in your browser, wait for it to finish loading, and REFRESH/REPEAT until you have all of the ID's accounted for in /output/xml_output/*.xml. */
			
			//FIRST BLOCK
			/*
			//CHANGE THIS FILENAME to the name of the file that has the id's you're looking to grab.
			$str = file_get_contents("./data/ids.csv");
			$ids = explode(",", $str);
			$recs = "";
			
			for($i = 0; $i < count($ids); $i++)
			{
				$id = $ids[$i];
				if(!file_exists("output/xml_output/" . $id . ".xml"))
				{
					$rec = file_get_contents("http://webservices.lib.harvard.edu/rest/mods/via/olvwork" . $id);
					file_put_contents("output/xml_output/" . $id. ".xml", $rec);
				}
			}
			*/
			//END OF FIRST BLOCK; you should now have xml records in your output/xml_output/ directory
			
			
			/////////////////////////////////////////
			
			
			/* After you've gotten all the .xml files you wanted in output/xml_output/, comment the first block out and uncomment this second block.  It will loop through all the XML files and convert them to JSON. */
			//SECOND BLOCK
			/*
			if ($handle = opendir('./output/xml_output'))
			{
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$fname = substr($entry, 0, strlen($entry) - 4);
						if(!file_exists("./output/json_output/" . $fname . ".json"))
						{
							$arr = xmlToArray("./output/xml_output/" . $entry);
							
							file_put_contents("output/json_output/" . $fname . ".json", json_encode($arr));
						}
					}
				}
				closedir($handle);
				
			}
			*/
			//END OF SECOND BLOCK; you should now have json records in your output/json_output/ directory ready to be ingested using the ruby script ingest/curarium_ingest.rb
		?>
		
	</body>
</html>