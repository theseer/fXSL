<?php

use TheSeer\fXSL\fXSLCallback;
use TheSeer\fXSL\fXSLTProcessor;

require '../src/fxslcallback.php';
require '../src/fxsltprocessor.php';

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

