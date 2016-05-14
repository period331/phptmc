<?php

namespace TMC;

/**
 * Class Message
 * @package TMC
 */
class Message
{
    protected $protocolVersion = 2;

    protected $messageType = null;

    protected $statusCode = null;

    protected $statusPhrase = null;

    protected $flag = null;

    protected $token = null;

    protected $content = null;

    /**
     * Message constructor.
     * @param int $protocolVersion
     * @param null|int $messageType
     * @param null|int $statusCode
     * @param null|int $statusPhrase
     * @param null|int $flag
     * @param null|string  $token
     * @param null|array $content
     */
    public function __construct(
        $protocolVersion = 2,
        $messageType = null,
        $statusCode = null,
        $statusPhrase = null,
        $flag = null,
        $token = null,
        $content = null
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->messageType = $messageType;
        $this->statusCode = $statusCode;
        $this->statusPhrase = $statusPhrase;
        $this->flag = $flag;
        $this->token = $token;
        $this->content = is_array($content) ? $content : array();
    }

    /**
     * 更新message中自定义的数据
     *
     * @param array $otherContent
     */
    public function updateContent(array $otherContent)
    {
        if (is_array($otherContent) && $otherContent) {
            $this->content = array_merge($this->content, $otherContent);
        }
    }

    public function toArray()
    {
        return array(
            "protocolVersion" => $this->protocolVersion,
            "messageType" => $this->messageType,
            "statusCode" => $this->statusCode,
            "statusPhrase" => $this->statusPhrase,
            "flag" => $this->flag,
            "token" => $this->token,
            "content" => $this->content
        );
    }

    public function toString()
    {
        return json_encode($this->toArray());
    }
    
    /**
     * @return int
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @param int $protocolVersion
     */
    public function setProtocolVersion($protocolVersion)
    {
        $this->protocolVersion = $protocolVersion;
    }

    /**
     * @return null
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * @param null $messageType
     */
    public function setMessageType($messageType)
    {
        $this->messageType = $messageType;
    }

    /**
     * @return null
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param null $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return null
     */
    public function getStatusPhrase()
    {
        return $this->statusPhrase;
    }

    /**
     * @param null $statusPhrase
     */
    public function setStatusPhrase($statusPhrase)
    {
        $this->statusPhrase = $statusPhrase;
    }

    /**
     * @return null
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param null $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @return null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param null $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return array|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param array|null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}