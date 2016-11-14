<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class UsernameChange extends DeviceTestCase {

    public function setUp() {
        self::$a_device->setUsername("test_user");
        self::assertFalse( self::$a_device->getGateway()->register() );
    }

    public function tearDown() {
        self::$a_device->setUsername("device_1");
        self::$a_device->getGateway()->kill();
        self::getProfile("auth")->rescan(); 
    }

    public function main($sip_uri) {
        $target = self::B_EXT .'@'. $sip_uri;
        $ch_a = self::$a_device->originate($target);
        self::assertEmpty( $ch_a );

        self::$a_device->getGateway()->kill();
        self::getProfile("auth")->rescan(); 

        $this->assertTrue( self::$a_device->getGateway()->register() );

        $target = self::B_EXT .'@'. $sip_uri;
        $ch_a = self::ensureChannel( self::$a_device->originate($target) );
        $ch_b = self::ensureChannel( self::$b_device->waitForInbound() );

        self::ensureAnswer($ch_a, $ch_b);
        self::hangupBridged($ch_a, $ch_b);
    }

}