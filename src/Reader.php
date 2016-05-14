<?php

namespace TMC;

use TMC\Types\HeaderType;
use TMC\Types\ValueType;

/**
 * Class Reader
 * @package TMC
 */
class Reader
{
    public static function read($stream)
    {
        $message = new Message();

        $protocolVersionHex = substr($stream, 0, 2);
        $offset = 2;
        $protocolVersion = unpack('C', hex2bin($protocolVersionHex))[1];
        $message->setProtocolVersion($protocolVersion);

        $messageTypeHex = substr($stream, $offset, 2);
        $offset += 2;
        $messageType = unpack('C', hex2bin($messageTypeHex))[1];
        $message->setMessageType($messageType);

        $headerTypeHex = substr($stream, $offset, 4);
        $offset += 4;
        $header_type = unpack('v', hex2bin($headerTypeHex))[1];

        while ($header_type != HeaderType::END_OF_HEADERS) {
            if ($header_type == HeaderType::TOKEN) {
                list($token, $offset) = static::readCountedStr($stream, $offset);
                $message->setToken($token);
                
            } elseif ($header_type === HeaderType::CUSTOM) {
                list($key, $offset) = static::readCountedStr($stream, $offset);
                list($value, $offset) = static::readCustomValue($stream, $offset);
                $message->updateContent(array($key => $value));
                
            } elseif ($header_type === HeaderType::STATUS_CODE) {
                $statusCodeHex = substr($stream, $offset, 8);
                $offset += 8;
                $message->setStatusCode(unpack('I', hex2bin($statusCodeHex))[1]);
                
            } elseif ($header_type === HeaderType::STATUS_PHRASE) {
                list($statusPhrase, $offset) = static::readCountedStr($stream, $offset);
                $message->setStatusPhrase($statusPhrase);
            } elseif ($header_type === HeaderType::FLAG) {
                $flagHex = substr($stream, $offset, 8);
                $offset += 8;
                $message->setFlag(unpack('I', hex2bin($flagHex))[1]);
            }

            $headerTypeHex = substr($stream, $offset, 4);
            $offset += 4;
            $header_type = unpack('v', hex2bin($headerTypeHex))[1];
        }
        
        return $message;
    }

    private static function readCountedStr($stream, $offset)
    {
        $length_hex = substr($stream, $offset, 8);
        $offset += 8;
        $length = unpack('I', hex2bin($length_hex))[1];

        if ($length > 0) {
            $str_hex = substr($stream, $offset, $length * 2);
            $offset += $length * 2;
            return array(implode('', array_map('chr', unpack('C*', hex2bin($str_hex)))), $offset);
        } else {
            return array(null, $offset);
        }
    }

    private static function readCustomValue($stream, $offset)
    {
        $_type_hex = substr($stream, $offset, 2);
        $offset += 2;
        $_type = unpack('C', hex2bin($_type_hex))[1];

        if ($_type === ValueType::VOID) {
            return array(null, $offset);
        }
        
        if ($_type === ValueType::BYTE) {
            $byte_hex = substr($stream, $offset, 2);
            $offset += 2;
            return array(unpack('C', hex2bin($byte_hex))[1], $offset);
        } 
        
        if ($_type === ValueType::INT16) {
            $int16Hex = substr($stream, $offset, 4);
            $offset += 4;
            return array(unpack('v', hex2bin($int16Hex))[1], $offset);
        }
        
        if ($_type === ValueType::INT32) {
            $int32Hex = substr($stream, $offset, 8);
            $offset += 8;
            return array(unpack('V', hex2bin($int32Hex))[1], $offset);
        }
        
        if ($_type === ValueType::INT64) {
            return static::readInt64($stream, $offset);
        }
        
        if ($_type === ValueType::DATE) {
            return static::readInt64($stream, $offset);
        }
        
        if ($_type === ValueType::BYTE_ARRAY) {
            $_lHex = substr($stream, $offset, 8);
            $offset += 8;
            $length = unpack('V', hex2bin($_lHex))[1];
            $byteArrayHex = substr($stream, $offset, $length * 2);
            $offset += $length * 2;
            return array(implode('', array_map('chr', unpack('C*', hex2bin($byteArrayHex)))), $offset);
        }
        
        return static::readCountedStr($stream, $offset);
    }

    /**
     * @param string $stream
     * @param int $offset
     * @return int
     */
    private static function readInt64($stream, $offset)
    {
        $int64Hex = substr($stream, $offset, 16);
        $offset += 16;
        
        if (PHP_VERSION_ID >= 50600) {
            return array(unpack('P', hex2bin($int64Hex))[1], $offset);
        }
        
        return array(0, $offset);
    }
}
