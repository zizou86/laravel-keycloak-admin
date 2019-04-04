<?php
namespace Scito\Keycloak\Admin\Token;

use function date_create;
use DateTime;

class Token
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $token;
    /**
     * @var DateTime
     */
    private $expires;

    public function __construct(string $type, string $token, DateTime $expires)
    {
        $this->type = ucfirst($type);
        $this->token = $token;
        $this->expires = $expires;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getContent()
    {
        return $this->token;
    }

    public function __toString()
    {
        return (string)$this->getContent();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->expires < date_create();
    }
}
