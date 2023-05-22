#!/bin/bash
echo "== Deployment Started =="

git pull origin main
echo " - Get Latest Source Code: OK"

git push tca main
echo " - push to secondary repository: OK"

ssh demo@s6.thecloudalert.com -t "./cod.sh"

now=$(date)
echo "*** finished at $now"
