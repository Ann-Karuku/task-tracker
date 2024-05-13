<?php

$conn = new mysqli('localhost','root','','dbname');

if (!$conn) {
	echo "Connection failed!";
}