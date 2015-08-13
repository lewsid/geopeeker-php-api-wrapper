GeoPeekerApiWrapper v0.01
=========================

This wrapper is for use with the GeoPeeker API, available to Pro and Enterprise users.

Example Usage
-------------

	$public_key = '12f0b42a5c5dad851c5995f6ddd346812'; //Both keys can be found in the Account interface
	$private_key = '4be6a55c3d72f077f675101d1b4132f7';

	$wrapper = new GeoPeekerApiWrapper($public_key, $private_key);
    $response = $wrapper->doPeek('example.com', 'en', null, 1000, array(0 => 'virginia'), array(0 => '640x960'));

Example Response (formatted)
----------------------------

    {
	  "success": 1,
	  "locations": {
	    "virginia": {
	      "ip": "93.184.216.34",
	      "ping": "2",
	      "dns": "<strong>DNS Records</strong><br>example.com name server a.iana-servers.net.<br />
					\nexample.com name server b.iana-servers.net.<br />\n<br><strong>A Records</strong><br>
					example.com has address 93.184.216.34<br />\n<br><strong>CNAME Records</strong><br>
					example.com has no CNAME record<br />\n<br><strong>MX Records</strong><br>example.com has 
					no MX record<br />\n<br><strong>TXT Records</strong><br>example.com descriptive text \
					"v=spf1 -all\"<br />\nexample.com descriptive text \"$Id: example.com 4380 2015-08-12 
					20:14:21Z davids $\"<br />\n<br><strong>SOA Records</strong><br>example.com has SOA record 
					sns.dns.icann.org. noc.dns.icann.org. 2015081206 7200 3600 1209600 3600<br />\n",
	      "renders": {
	        "640x960": {
	          "original": "https://www.geopeeker.com/uploads/api/55ccb0a24abdb_en_640x960_4.png",
	          "thumb": "https://www.geopeeker.com/uploads/api/55ccb0a24abdb_en_640x960_4_thumb.png",
	          "source": "https://www.geopeeker.com/uploads/api/55ccb0a24abdb_en_640x960_4_source.txt"
	        }
	      }
	    }
	  }
	}


License
-------

GeoPeekerApiWrapper is open-sourced software licensed under the MIT License.


Contact
-------

  - chris@geopeeker.com
  - @geopeeker on Twitter
  - github.com/lewsid
  
