fXSL
============

The classes contained within this repository extend the standard XSLTProcessor to use exceptions at
all occasions of errors instead of PHP warnings, notices or semi completed transformations. 
They also add various custom methods and shortcuts for convinience and to allow a nicer API to implement callbacks
to the PHP stack.

Requirements
------------

    PHP: 5.3.3 (5.3.0-5.3.2 had serious issues with spl stacked autoloaders)
    Extensions: dom, xsl, libxml


Installation
------------
fXSL can be installed using the PEAR Installer, the backbone of the PHP Extension and Application Repository that provides a distribution system for PHP packages.

Depending on your OS distribution and/or your PHP environment, you may need to install PEAR or update your existing PEAR installation before you can proceed with the instructions in this chapter.
``sudo pear upgrade PEAR`` usually suffices to upgrade an existing PEAR installation. The PEAR Manual explains how to perform a fresh installation of PEAR.

The following two commands are all that is required to install fDOMDocument using the PEAR Installer:

    sudo pear channel-discover pear.netpirates.net
    sudo pear install TheSeer/fXSL

After the installation you can find the source files inside your local PEAR directory; the path is usually either
``/usr/share/pear/TheSeer/fXSL`` (Fedora/Redhat) or ``/usr/lib/php/TheSeer/fXSL`` (Debian/Ubuntu).


Usage
-----

Simply require/include the autoload.php supplied and you can start using fXSL as a
drop in replacement for the standard XSLTProcessor.

Usage Samples
-------------

PHP Code:

	<?php

	use TheSeer\fXSL\fXSLCallback;
	use TheSeer\fXSL\fXSLTProcessor;

	require 'TheSeer/fXSL/autoload.php';

	function demo() {
	   return 'Demo reply';
	}

	class foo {
	   public function bar($a, $b) {
	      $x = new \DOMDocument();
	      $x->loadXML('<?xml version="1.0" ?><root />');
	      $p = $x->createTextNode($a . ' -> ' . $b);
	      $x->documentElement->appendChild($p);
	      return $x->documentElement;
	   }
	}

	$tpl = new DOMDocument();
	$tpl->load('test.xsl');

	$dom = new DOMDocument();

	$xsl = new fXSLTProcessor($tpl);
	$xsl->registerPHPFunctions('demo');

	$test = new fXSLCallback('test:only','test');
	$test->setObject(new foo());

	$xsl->registerCallback($test);

	$result = $xsl->transformToXml($dom);

	$tpl->formatOutput = true;
	echo "Template:\n" . $tpl->saveXML();

	echo "\n\nOutput:\n".$result;
   
	?>

The 'test.xsl' XSL Stylesheet used:

	<?xml version="1.0" encoding="UTF-8"?>
	<xsl:stylesheet version="1.0" exclude-result-prefixes="php foo"
 		xmlns:foo="test:uri"
		extension-element-prefixes="php func" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
		xmlns:php="http://php.net/xsl">

		<xsl:output method="xml" indent="yes" encoding="utf-8" />

		<xsl:template match="/">
			<root>
				<!-- classic php function callback -->
				<demo><xsl:value-of select="php:function('demo')" /></demo>

				<!-- fXSL registered callback method -->
				<test><xsl:copy-of select="test:bar('hello','world')" /></test>
			</root>
		</xsl:template>

	</xsl:stylesheet>

 
Changelog
---------
#####Release 1.1.0
* Added loadStylesheetFromFile and loadStylesheetFromXML methods
* Clear xml errors on construct
* Changed protected properties and methods to private

#####Release 1.0.4
* PHP 5.4 compatibilty: set a default security preference so writing files is allowed

#####Release 1.0.3
* Changed error detecting code to catch more problems

#####Release 1.0.2
* Extended Exception code to better show actual errors

#####Release 1.0.1
* Added support for black- and whitelisting of methods
* Generate nicer xsl code
* Various Bugfixes

#####Release 1.0.0
* Initial release
