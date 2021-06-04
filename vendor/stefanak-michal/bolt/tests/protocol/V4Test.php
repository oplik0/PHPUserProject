<?php

namespace Bolt\tests\protocol;

use Bolt\PackStream\v1\Packer;
use Bolt\PackStream\v1\Unpacker;
use Bolt\protocol\V4;
use Bolt\tests\ATest;
use Exception;

/**
 * Class V4Test
 *
 * @author Michal Stefanak
 * @link https://github.com/stefanak-michal/Bolt
 *
 * @covers \Bolt\protocol\AProtocol
 * @covers \Bolt\protocol\V4
 *
 * @package Bolt\tests\protocol
 * @requires PHP >= 7.1
 * @requires mbstring
 */
class V4Test extends ATest
{
    /**
     * @return V4
     */
    public function test__construct()
    {
        $cls = new V4(new Packer, new Unpacker, $this->mockConnection());
        $this->assertInstanceOf(V4::class, $cls);
        return $cls;
    }

    /**
     * @depends test__construct
     * @param V4 $cls
     */
    public function testPull(V4 $cls)
    {
        self::$readArray = [1, 3, 0, 1, 2, 0];
        self::$writeBuffer = [hex2bin('000bb13fa2816eff83716964ff0000')];

        $res = $cls->pull(['n' => -1, 'qid' => -1]);
        $this->assertIsArray($res);
        $this->assertCount(2, $res);
    }

    /**
     * @depends test__construct
     * @param V4 $cls
     */
    public function testPullFail(V4 $cls)
    {
        self::$readArray = [4, 5, 0, 1, 2, 0];
        self::$writeBuffer = [
            hex2bin('000bb13fa2816eff83716964ff0000'),
            hex2bin('0002b00f0000')
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('some error message (Neo.ClientError.Statement.SyntaxError)');
        $cls->pull(['n' => -1, 'qid' => -1]);
    }

    /**
     * @depends test__construct
     * @param V4 $cls
     */
    public function testDiscard(V4 $cls)
    {
        self::$readArray = [1, 2, 0];
        self::$writeBuffer = [hex2bin('000bb12fa2816eff83716964ff0000')];

        $this->assertTrue($cls->discard(['n' => -1, 'qid' => -1]));
    }

}