<?php

namespace TMC;

/**
 * Class TestWriter
 * @package TMC
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
    public function testWrite1()
    {
        $content = json_decode('{
    "topic": "taobao_trade_TradeBuyerPay",
    "userid": 720978815,
    "__kind": 3,
    "publisher": "12497914",
    "retried": 1,
    "content": "{\"buyer_nick\":\"茉色容颜\",\"payment\":\"1799.00\",\"oid\":571090161493428,\"tid\":571090161493428,\"type\":\"guarantee_trade\",\"seller_nick\":\"htc兴长信达专卖店\"}",
    "id": 2131800080537682000,
    "data_id": 571090161493428,
    "time": 1394862763110,
    "nick": "htc兴长信达专卖店",
    "dataid": 571090161493428,
    "born_time": 1394862763110,
    "outtime": 1395035520946
  }', true);
        $m = new Message(2, 2, null, null, null, 'd2c3e864-cf6d-4888-8fb3-5bb95719b01b', $content);
//        Writer::write($m);
    }
}
