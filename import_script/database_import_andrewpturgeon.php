<?php
//ENTER THE RELEVANT INFO BELOW
$mysqlDatabaseName ='db646940417';
$mysqlUserName ='dbo646940417';
$mysqlPassword ='u4craZ8s?';
$mysqlHostName ='db646940417.db.1and1.com';
$mysqlImportFilename ='eyecentersofohio-dev.sql';

//DO NOT EDIT BELOW THIS LINE
//Export the database and output the status to the page
$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
exec($command,$output=array(),$worked);
switch($worked){
    case 0:
        echo 'Import file ' .$mysqlImportFilename .' successfully imported to database ' .$mysqlDatabaseName;
        break;
    case 1:
        echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values. MySQL Database Name: ' .$mysqlDatabaseName .' MySQL User Name: ' .$mysqlUserName .' MySQL Password: NOTSHOWN MySQL Host Name: ' .$mysqlHostName .' MySQL Import Filename: ' .$mysqlImportFilename;
        break;
}
?>