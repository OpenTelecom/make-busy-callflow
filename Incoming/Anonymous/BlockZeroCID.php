<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class BlockZeroCID extends IncomingTestCase {

    public function setUp() {
        self::setConfig("block_anonymous_caller_id", true);
    }

    public function tearDown() {
        self::setConfig("block_anonymous_caller_id", false);
    }

    public function main($sip_uri) {
        $number = self::$carrier_number->toNpan();
        $target = self::CARRIER_NUMBER .'@'. $sip_uri;

        $channel_a = self::ensureChannel( self::$offnet->originate($target, 5, ['origination_caller_id_number' => '00000']) );
        $channel_b = self::$a_device->waitForInbound();
        self::assertEmpty($channel_b);
    }

}