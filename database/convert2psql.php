<?php

$source = "../database/Master.sql";
$output = "../database/baseball.sql";

$enum = 'varchar(1)'; // convert enum to this

if ( !file_exists($source) ) {
 die("File not found: $sourcen");
}

$fd = fopen($source, "r");
$result = fread($fd, filesize($source));
fclose($fd);

$result = mysql2postgre($result);

$fd = fopen($output, "w");
if (fwrite($fd, $result)) {
 echo "OKn";
} else {
 echo "Failedn";
}
fclose($fd);




function mysql2postgre($source) {
 global $enum;

 $result = $source;
 $result = preg_replace('/Type=MyISAM/i', '', $result);

 // convert line comments
 $result = preg_replace("/#(.*)/", '--$1', $result);
 // and compress newlines
 $result = preg_replace("/n{2,}/", "nn", $result);

 // get rid of proprietary code
 $result = preg_replace("/DROP TABLE IF EXISTSW+.+/i", '', $result);

 // indices
 $result = preg_replace("/(.*)UNIQUE KEY.+((.+))/i",
 "$1UNIQUE ($2)", $result);

 // a little hack to save primary keys
 $result = preg_replace("/(.*)PRIMARY KEY.+((.+))/i",
 "$1PRIMARY ($2)", $result);
 $result = preg_replace("/,n.*KEYW.+((.+))/i",
 "n-- was KEY ($1)", $result);
 $result = preg_replace("/(.*)PRIMARY.+((.+))/i",
 "$1PRIMARY KEY (\2)", $result);

 $result = preg_replace("/(.*?)(w+).+auto_increment/i",
 '$1$2 SERIAL', $result);

 // Postgre doesn't support the binary modifier
 $result = preg_replace('/binary/i', '', $result);

 // type transformations
 $result = preg_replace('/enum(.+)/i', $enum, $result);

 $result = preg_replace('/tinyint(.+)/i', 'smallint', $result);
 $result = preg_replace('/smallint(.+)/i', 'smallint', $result);
 $result = preg_replace('/meduimint(.+)/i', 'int', $result);
 $result = preg_replace('/int(.+)/i', 'int', $result);

 // Most of my default dates are '0000-00-00'
 $result = preg_replace("/datetime(.*) default '.*'/i",
 'datetime$1', $result);
 $result = preg_replace("/date(.*) default '.*'/i",
 'date$1', $result);


 return $result;
}

?>