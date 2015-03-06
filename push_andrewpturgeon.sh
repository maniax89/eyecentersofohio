#!/bin/sh
echo "Pushing latest checkout to andrewpturgeon.com/eyecentersofohio..."
/usr/local/bin/git-ftp push -s uat

echo "Uploading eyecentersofohio-dev.sql to andrewpturgeon.com..."
/usr/bin/curl -u u75866667:u4craZ8s? -T /home/turgeon/Dev/eyecentersofohio/eyecentersofohio-dev.sql ftp://andrewpturgeon.com/clients/eyecentersofohio/import_script/ 

echo "Running import script using curl..."
/usr/bin/curl -u turgeon:upload123 clients.andrewpturgeon.com/eyecentersofohio/import_script/database_import_andrewpturgeon.php

exit 0