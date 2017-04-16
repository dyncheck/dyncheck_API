API Interface specification:


 1. Generate API key

You can do it in your profile 

 2. Upload file and start scanning:

To start checking process for you files you should: 
1) Change value of api_key variable in upload_and_scan.php (see php examples below)
2) Select checking type, engines and allowed IP's (Optional)
Available AV engines: 
AV name	AV code
360 Total Security	baidu360
AVG Anti-Virus Business Edition	avg
AhnLab V3 Light	ahnlab
Avast Internet Security	avast
Avira Internet Security	avira
BitDefender Total Security	bitdef
BullGuard Internet Security	bullguard
Comodo Internet Security	comodo
DrWeb Total Security	drweb
Emsisoft Internet Security	emsisoft
Eset Smart Security	eset
F-Secure Internet Security	fsecure
Fortinet Smart Security	fortinet
Kaspersky Internet Security	kis
Malwarebytes Anti-Malware	malwarebytes
McAfee Endpoint Protection	mcafee
Norton Internet Security	norton
Panda Internet Security	panda
Sophos Anti-Virus	sophos
Symantec Endpoint Security 12	symantec
Symantec Endpoint Security 14	symanteccorp
Trend Micro Internet Security	trendmicro
Windows Defender	windef 3) Put upload_and_scan.php to directory with files you want to scan 
4) Type in terminal: 

php upload_and_scan.php filename1.exe
API answer should look like this: 

File id: 7af3b63bd0c3079c909f270cf948c97y
File: filename1.exe | Scan started. Waiting for results...

 3. To manually get information about scanning:

1) Change value of api_key variable in get_info.php (see php examples below)
2) You should type in terminal File id you get in previous step 

php get_info.php 7af3b63bd0c3079c909f270cf948c97y
API answer should look like this: 

{"error":"false",
"message":"",
"file_info":{"id":"7af3b63bd0c3079c909f270cf948c97y","type_check":"1","name":"filename1.exe","start_scan":"2016-12-30 20:02:29","end_scan":"1970-01-01 00:00:00","sha256":"6f948d9b438a3a1404858af055984c19d75df0e87af8ef104ec18e8441f73bb2"},
"containers":[{"txt_code":"avast","updated_at":"2016-12-30 15:57:17","check_result":""},{"txt_code":"eset","updated_at":"2016-12-30 15:57:17","check_result":""}],
"status_check":"processing"}