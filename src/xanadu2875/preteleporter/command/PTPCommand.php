<?php

namespace xanadu2875\preteleporter\command;

use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\command;

class PTPCommand extends command\PluginCommand
{
  public function __construct(Plugin $owner)
  {
    parent::__construct("ptp", $owner);

    $this->setPermission("preteleporter.command.ptp");
    $this->setAliases(["PTP", "PreTP", "PreTereporter"]);
    $this->setPermissionMessage("このプラグインは正しく動作できませんでした");
    $this->setDescription("転移先の名前が表示されているUIを送ります");
    $this->setUsage("/ptp");
  }

  public function execute(command\CommandSender $sender, string $commandLabel, array $args): bool
  {
    if($sender instanceof Player){
      $this->getPlugin()->sendTPTUI($sender);
      return true;
    }

    return false;
  }
}
