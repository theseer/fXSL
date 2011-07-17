#!/bin/sh
rm -f fXSL*.tgz
mkdir -p tmp/TheSeer/fXSL
cp -r src/* tmp/TheSeer/fXSL
phpab -o tmp/TheSeer/fXSL/autoload.php -b src src
cp package.xml tmp
cd tmp
pear package
mv fXSL*.tgz ..
cd ..
rm -rf tmp
