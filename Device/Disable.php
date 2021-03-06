<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class Disable extends DeviceTestCase {

    public function setUpTest() {
        self::$b_device->disableDevice();
        self::assertFalse(self::$b_device->getGateway()->register());
    }

    public function tearDownTest() {
        self::$b_device->enableDevice();
    }

    public function main($sip_uri) {
        $target = self::B_EXT .'@'. $sip_uri;
        $channel_a = self::ensureChannel( self::$a_device->originate($target) );
        $channel_b = self::$b_device->waitForInbound();
        self::assertEmpty($channel_b);
    }

}