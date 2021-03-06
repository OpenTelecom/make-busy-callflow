<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class CallerIdOffnet extends DeviceTestCase {

    public function main($sip_uri) {
        $target  = '1' . self::OFFNET_NUMBER .'@'. $sip_uri;
        $channel_a = self::ensureChannel( self::$a_device->originate($target) );
        $channel_b = self::ensureChannel( self::$offnet_resource->waitForInbound('1' . self::OFFNET_NUMBER) );
        self::assertEquals(
            self::$a_device->getCidParam("external")->number,
            urldecode($channel_b->getEvent()->getHeader("Caller-Caller-ID-Number"))
        );
        self::hangupBridged($channel_a, $channel_b);
    }

}