<?php

namespace TheSeer\fXSL;

class fXSLCallbackTest extends \PHPUnit_Framework_TestCase {

    public function testSimple() {
        $object = new \stdClass();

        $callback = new fXSLCallback("test:only");

        $this->assertEquals("test:only", $callback->getNamespace());

        $callback->setObject($object);
        $this->assertEquals($object, $callback->getObject());
    }

}
