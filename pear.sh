#!/bin/sh
rm -f fXSL*.tgz
mkdir -p tmp/TheSeer/fXSL
mkdir -p tmp/tests
cp -r src/* tmp/TheSeer/fXSL
cp -r tests/* tmp/tests
cp package.xml phpunit.xml.dist LICENSE tmp
phpab -o tmp/TheSeer/fXSL/autoload.php -b src src
cd tmp
pear package
mv fXSL*.tgz ..
cd ..
rm -rf tmp
