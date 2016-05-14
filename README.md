## PHP TMC

> 淘宝TMC消息服务框架
> 仅支持PHP5.6及以上版本

### 功能

[x] 数据解包
[x] 数据封包
[]  简单版websocket client
[]  基于swoole 的websocket client

### 使用

由于当前只完成了数据的封包和解包（测试不足），所以在对接TMC的时候必须自己实现一个`websocket client`，来和淘宝的服务器做交互


```php
use TMC\Reader;
use TMC\Writer;

public function onMessage($data) {
	$m = Reader::read($data);

	if ($m->getMessageType() === 1) { // 握手
	} elseif ($m->getMessageType() === 2) {  // 服务器推送数据
		// do something

		$this->write(Writer::write(new ConfirmMessage($m->getDataId()))));

	} elseif ($m->getMessage() === 3) { // 主动拉取消息后返回
		// do something
	}
}

```




