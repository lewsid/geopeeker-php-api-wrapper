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
	      "dns": "DNS Recordsexample.com name server b.iana-servers.net.\nexample.com name server a.iana-servers.net.\n
	              A Recordsexample.com has address 93.184.216.34\nCNAME Recordsexample.com has no CNAME record\n
	              MX Recordsexample.com has no MX record\n
	              TXT Recordsexample.com descriptive text \"v=spf1 -all\"\n
	              example.com descriptive text \"$Id: example.com 4380 2015-08-12 20:14:21Z davids $\"\n
	              SOA Recordsexample.com has SOA record sns.dns.icann.org. noc.dns.icann.org. 2015081206 7200 3600 1209600 3600\n",
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
  
