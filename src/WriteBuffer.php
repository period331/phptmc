<?php
namespace TMC;


/**
 * Class WriteBuffer
 * @package TMS
 */
class WriteBuffer
{
    /**
     * @var string
     */
    private $buffer;

    /**
     * write a byte to buffer
     * @param $byte
     */
    public function byte($byte)
    {
        $this->buffer .= bin2hex(pack('C', $byte));
    }

    /**
     * write unsigned integer 16
     * @param $int16
     */
    public function int16($int16)
    {
        $this->buffer .= bin2hex(pack('v', $int16));
    }

    /**
     * write unsigned integer 32 to buffer
     * @param $int32
     */
    public function int32($int32)
    {
        $this->buffer .= bin2hex(pack('V', $int32));
    }

    /**
     * write unsigned integer 64 to buffer
     * @param $int64
     */
    public function int64($int64)
    {
        $this->buffer .= bin2hex(pack('P', $int64));
    }

    /**
     * write a string to buffer
     * @param $string
     */
    public function string($string)
    {
        if (strlen($string) > 0) {
            $this->int32(strlen($string));
            $this->buffer .= bin2hex(implode('', array_map('chr', unpack('C*', $string))));
        } else {
            $this->byte(0);
        }
    }

    /**
     * @return string
     */
    public function getHexBuffer()
    {
        return $this->buffer;
    }

    /**
     * @return string
     */
    public function getBuffer()
    {
        return hex2bin($this->buffer);
    }

}
