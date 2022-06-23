<?php

declare(strict_types=1);

namespace NhanAZ\Track;

use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\event\server\CommandEvent;

class Main extends PluginBase implements Listener {

	public const HandleFont = TF::ESCAPE . "　";

	public $history;

	public function RemoveConfig(): void {
		foreach ($this->history->getAll() as $history => $data) {
			$this->history->remove($history);
		}
	}

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->saveResource("history.yml");
		$this->history = new Config($this->getDataFolder() . "history.yml", Config::YAML);
		if ($this->getConfig()->get("DeleteHistory")["onEnable"]) {
			$this->RemoveConfig();
		}
	}

	public function onDisable(): void {
		if ($this->getConfig()->get("DeleteHistory")["onDisable"]) {
			$this->RemoveConfig();
		}
	}

	public function onCommandEvent(CommandEvent $event) {
		$cmd = $event->getCommand();

		$time = date("D d/m/Y H:i:s(A)");
		$name = $event->getSender()->getName();

		$this->history->set("{$time} : {$name}", $cmd);
		$this->history->save();

		$UnicodeFont = $this->getConfig()->get("UnicodeFont");
		/* HVUf = Handle Variable Unicode Font */
		$HVUf = ($UnicodeFont == true ? self::HandleFont : "");

		$this->getLogger()->info("{$name} > /{$cmd}");

		foreach ($this->getServer()->getOnlinePlayers() as $tracker) {
			if ($tracker->hasPermission("track.tracker")) {
				$tracker->sendMessage("{$HVUf}[Track] {$name} > /{$cmd}");
			}
		}
		return true;
	}
}
