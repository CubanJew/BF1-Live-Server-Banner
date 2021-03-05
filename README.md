# BF1-Live-Server-Banner
Dynamically generate image with BF1 PC server information in real-time in PHP using battlefieldtracker API JSON data.

# Usage
Execute `/sig.php` to use hardcoded default server ID. Server ID may be supplied as *s_id* parameter (e.g., `sig.php?s_id=5428144750219`)

# Installation Instructions
1) Upload "sig.php" and "/media" directory to web server.
2) Obtain an API key from https://battlefieldtracker.com/site-api
3) Open up "sig.php" and replace _YOUR_API_KEY_ with your battletracker API key inside of `getData()` function (in  curl_setopt($ch, CURLOPT_HTTPHEADER....)

4) (OPTIONAL) BF1 Server ID will randomly change. In order to optimize execution time of sig.php, a default serverID ($nwgServerID) is hardcoded in the script if server ID argument is not provided. A separate script (sig_scrape_server_id.php) may be run via CRON job in CPANEL to updated the default hardcoded serverID in sig.php. Edit the following search URL inside *scrapeServerID()* of *sig_scrape_server_id.php*:
	`$html = file_get_html('https://battlefieldtracker.com/bf1/servers?platform=pc&name=nwg');`
	Make sure the search URL only retrieves a single result. 


When additional maps are released, you'll need to add new background canvas images containing a thumbnail picture of the map into the `/media/img_canvas/` directory. The GIMP image template titled "banner template.xcf" is included in this directory.

Warning: If testing this on a local Windows-based Apache server (e.g., XAMPP), you'll need to add the SSL sertificate per directions here: http://stackoverflow.com/questions/29822686/curl-error-60-ssl-certificate-unable-to-get-local-issuer-certificate
