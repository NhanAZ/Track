<?php


declare(strict_types=1);

namespace NhanAZ\Track;

use pocketmine\command\CommandSender;
use SOFe\InfoAPI\Info;

class SenderInfo extends Info
{

    public function __construct(
        protected CommandSender $value
    )
    {
    }

    public function toString() : string
    {
        // TODO: Implement toString() method.
    }

    /**
     * @return CommandSender
     */
    public function getValue() : CommandSender
    {
        return $this->value;
    }

}