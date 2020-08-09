#!/bin/sh

echo  "Creating dt folder for SQLite...."
if [ ! -d /var/www/var/db ]; then
    mkdir -p /var/www/var/db;
echo  "Successfully create the data folder..."
fi;

echo  "Executing schema creation ... $(/var/www/bin/console doctrine:schema:create --no-interaction)"
echo "Schema created successfully...."

echo  "Pre-population of data... $(/var/www/bin/console doctrine:fixtures:load --no-interaction)"
echo "Data ha been populated successfully...."