<?php


declare(strict_types=1);

namespace NhanAZ\Track;

use RuntimeException;
use SOFe\InfoAPI\Info;
use SOFe\InfoAPI\InfoAPI;
use SOFe\InfoAPI\TimeInfo;

class CommandExecutionContextInfo extends Info
{

    public function __construct(
        protected SenderInfo $sender,
        protected TimeInfo $time,
        protected CommandInfo $command,
        protected string $label,
        protected array $arguments
    )
    {
    }

    public static function init() : void
    {
        InfoAPI::provideInfo(
            self::class,
            SenderInfo::class,
            "Track.CommandExecution.Sender",
            fn(self $info) : SenderInfo => $info->getSender()
        );
        InfoAPI::provideInfo(
            self::class,
            TimeInfo::class,
            "Track.CommandExecution.Time",
            fn(self $info) : TimeInfo => $info->getTime()
        );
    }

    public function toString() : string
    {
        throw new RuntimeException("ContextInfo must not be returned as a provided info");
    }

    /**
     * @return SenderInfo
     */
    public function getSender() : SenderInfo
    {
        return $this->sender;
    }

    /**
     * @return TimeInfo
     */
    public function getTime() : TimeInfo
    {
        return $this->time;
    }

    /**
     * @return CommandInfo
     */
    public function getCommand() : CommandInfo
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getLabel() : string
    {
        return $this->label;
    }

    /**
     * @return array
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }

}