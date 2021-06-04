<?php

namespace Bolt\tests\protocol;

use Bolt\PackStream\v1\Packer;
use Bolt\PackStream\v1\Unpacker;
use Bolt\protocol\V2;
use Bolt\tests\ATest;

/**
 * Class V2Test
 *
 * @author Michal Stefanak
 * @link https://github.com/stefanak-michal/Bolt
 *
 * @covers \Bolt\protocol\AProtocol
 * @covers \Bolt\protocol\V2
 *
 * @package Bolt\tests\protocol
 * @requires PHP >= 7.1
 */
class V2Test extends ATest
{
    /**
     * @return V2
     */
    public function test__construct()
    {
        $cls = new V2(new Packer, new Unpacker, $this->mockConnection());
        $this->assertInstanceOf(V2::class, $cls);
        return $cls;
    }
}
