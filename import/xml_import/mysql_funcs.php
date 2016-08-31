<?php

$test_db_host = "localhost";
$test_db_user = "msm";
$test_db_pwd  = "EetGiOj6";
//$test_db_pwd  = "claypigeon";
$test_db_name = "test_msm";

//$db_host = "sql";	// resolvable in /etc/hosts
//$db_user = "addige";
//$db_name = "adsystems";
//$db_pwd  = "rubberchicken";

$db_host = "192.168.1.254";	// resolvable in /etc/hosts
$db_user = "arnold";
$db_name = "dev_reporting";
$db_pwd  = "Ved12345";

if (TEST_DB) {
	$db_host = $test_db_host;
	$db_user = $test_db_user;
	$db_name = $test_db_name;
	$db_pwd  = $test_db_pwd;
} // if


$db_conn = mysql_connect( $db_host, $db_user, $db_pwd );
mysql_select_db( $db_name, $db_conn );


// some basic MySQL transaction handling routines:


function open_mysql()
{
GLOBAL $db_conn, $db_host, $db_user, $db_pwd, $db_name;
GLOBAL $msg_log;

	$db_conn = mysql_connect( $db_host, $db_user, $db_pwd );
	if ($db_conn && mysql_select_db( $db_name, $db_conn )) {
		$result = TRUE;
$qry = "set autocommit = 1";
$result = mysql_query( $qry, $db_conn );
	} else {
		message_log_append( $msg_log, mysql_error( $db_conn ), MSG_LOG_ERROR );
		$result = FALSE;
	}
	return( $result );

} // open_mysql


function begin( $db_conn )
{
GLOBAL $msg_log;

message_log_append( $msg_log, "START TRANSACTION" );
	return( mysql_query( "START TRANSACTION", $db_conn ) );
}


function commit( $db_conn )
{
GLOBAL $msg_log;

message_log_append( $msg_log, "COMMIT" );
	return( mysql_query( "COMMIT", $db_conn ) );
}


function rollback( $db_conn )
{
GLOBAL $msg_log;

message_log_append( $msg_log, "ROLLBACK" );
	return( mysql_query( "ROLLBACK", $db_conn ) );
}


function last_insert_id( $db_conn )
{
	$result = mysql_query( "SELECT LAST_INSERT_ID()", $db_conn );
	if ($result) {
		$record = mysql_fetch_array( $result );
		$value = ($record ? $record[ 0 ] : NULL);
	} else $value = NULL;
	return( $value );
}


function field_list( $table, $db_conn )
// return a string with the comma-separated list of fields in
// $table.  return NULL on error.
{
	$result = mysql_query( "SHOW COLUMNS FROM $table", $db_conn );
	if ($result) {
		$value = "";
		while ($record = mysql_fetch_array( $result )) {
			$value .= "," . $record[ "Field" ];
		}
		$value = substr( $value, 1 ); // remove leading comma
	} else $value = NULL;
	return( $value );
} // field_list


function site_name( $db_conn )
{
	$result = mysql_query( "SELECT SiteName FROM temp_header", $db_conn );
	if ($result) {
		$record = mysql_fetch_array( $result );
		$value = ($record) ? $record[ 0 ] : NULL;
	} else $value = NULL;
	return( $value );
}


function network_alias( $p_network, $db_conn )
// Look up the NCC alias for the given network tag
// return NULL if error.
{
	$qry = "SELECT NCCAlias from network WHERE Name = '$p_network'";
	$result = mysql_query( $qry, $db_conn );
	if ($result) {
		$record = mysql_fetch_array( $result );
		if ($record)
			$value = $record[ 0 ];
		else
			$value = NULL;
	} else $value = NULL;
	return( $value );
}


function agency_record( $agency_name, $oper_name )
{
GLOBAL $db_conn;
GLOBAL $msg_log;

	$qry = "SELECT * FROM agencies WHERE Operator =  '$oper_name' " .
			"AND Name = '$agency_name'";
	if (($sql_result = mysql_query( $qry, $db_conn )) &&
			($record = mysql_fetch_array( $sql_result ))) {
		$result = $record;
	} else {
//		message_log_append( $msg_log, "MySQL query failed: " . $qry, MSG_LOG_ERROR );
//		message_log_append( $msg_log, mysql_error( $db_conn ), MSG_LOG_ERROR );
		$result = NULL;
	}
	return( $result );

} // agency_record


function cust_record( $cust_name, $oper_name )
// fetch a record from the customer table and return
// it as an array.  return NULL on error.
{
GLOBAL $db_conn;
GLOBAL $msg_log;

	$qry = "SELECT * FROM customers WHERE Operator =  '$oper_name' " .
			"AND Name = '$cust_name'";
	if (($sql_result = mysql_query( $qry, $db_conn )) &&
			($record = mysql_fetch_array( $sql_result ))) {
		$result = $record;
	} else {
//		message_log_append( $msg_log, "MySQL query failed: " . $qry, MSG_LOG_ERROR );
//		message_log_append( $msg_log, mysql_error( $db_conn ), MSG_LOG_ERROR );
		$result = NULL;
	}
	return( $result );

} // cust_record


?>
