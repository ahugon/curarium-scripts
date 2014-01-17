via-extraction
==============

This hackish PHP script will download XML records in batches from Harvard's VIA.  It will then convert all the XML files to JSON.


Setup:
======

Clone the repository, then drop your .csv file of VIA record ID's into the data/ directory.

Next, update index.php (where it says "// CHANGE THIS FILENAME") to point to that .csv file.


Downloading XML from VIA:
=========================

You're now ready to run the script, so ensure that the "FIRST BLOCK" of code is uncommented, then load index.php in your browser.

It should run (with a blank screen) for 30 seconds, after which you should receive an error message to the effect of:

"Fatal error: Maximum execution time of 30 seconds exceeded"

Now, just refresh and repeat until the contents of output/xml_output/ matches what you're expecting to extract from VIA!


Converting XML to JSON:
=======================

Once you have all the XML files in output/xml_output/, simply re-comment "FIRST BLOCK" and uncomment "SECOND BLOCK".  The second block of code will convert all your XML files to JSON and stash them in output/json_output/ for you to use later in ingesting the JSON records to Curarium!


Ingesting JSON to Curarium:
===========================

Step 1: Be an admin on the Curarium site.  Find the collection "key" (should be a long hash string) for the collection you're ingesting into.

Step 2: Run the Ruby script (usage included at top of file) -- you'll need the "key" from Step 1.

Step 3: Done!
