<?php

namespace xanadu2875\preteleporter\command;

use pocketmine\plugin\Plugin;
use pocketmine\command;

class DeletePTPCommand extends command\PluginCommand
{
  public function __construct(Plugin $owner)
  {
    parent::__construct("delptp", $owner);

    $this->setPermission("preteleporter.command.deleteptp");
    $this->setAliases(["dtpt"]);
    $this->setPermissionMessage("権限がありません");
    $this->setDescription("指定したPTPを削除します");
    $this->setUsage("/delptp <name>\nExample: /delptp ロビー");
  }

  public function execute(command\CommandSender $sender, string $commandLabel, array $args) : bool
  {
    if(isset($args[0]))
    {
      if($this->getPlugin()->deletePTP($args[0]))
      {
        $sender->sendMessage("削除しました。");
        return true;
      }
      else
      {
        $sender->sendMessage("存在しない名前です");
      }
    }
    return false;
  }
}
