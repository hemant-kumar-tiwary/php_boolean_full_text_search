This function is use to convert text to Boolean compatible string.

Case 1.
	Input :  mysql AND PHP
	
	Output : +mysql +php
	
	
Case 2.
	Input :  mysql AND PHP AND linux
	
	Output : +mysql +php +linux


Case 3.
	Input :  mysql AND PHP OR Linux
	
	Output : +mysql +php linux
	

Case 3.
	Input :  mysql AND PHP Not Linux
	
	Output : +mysql +php -linux
	