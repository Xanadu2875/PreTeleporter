<?php

namespace xanadu2875\preteleporter\command;

use pocketmine\command;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class SetPTPCommand extends command\PluginCommand
{
  public function __construct(Plugin $owner)
  {
    parent::__construct("setptp", $owner);
    $this->setPermission("preteleporter.command.setptp");
    $this->setPermissionMessage("You don't have ");
    $this->setDescription("座標と名前を設定します");
    $this->setUsage("/setptp <name>\nExample: /setptp ロビー - 自分の座標の位置をロビーという名前で登録できます(OP専用)");
    $this->setAliases(["setPreTeleporter", "setPreTP", "setPTP"]);
  }

  public function execute(command\CommandSender $sender, string $commandLabel, array $args): bool
  {
    if(isset($args[0]))
    {
      if($sender instanceof Player)
      {
        if(!$this->getPlugin()->addCo($args[0], (int)$sender->x, (int)$sender->y, (int)$sender->z, $sender->getLevel()))
        {
          $sender->sendMessage("登録がキャンセルされました。その名前は既に登録されています");
          return false;
        }
      }
      else
      {
        for($i = 0; $i++; $i <= 4)
        {
          if(!isset($args[$i])) return false;
        }
        if($level = $this->getLevelByName($args[4]))
        {
          if(!$this->getPlugin()->addCo($args[0], (int)$args[1], (int)$args[2], (int)$args[3], $level))
          {
            $sender->sendMessage("登録がキャンセルされました。その名前は既に登録されています");
            return false;
          }
        }
      }
      return true;
    }
    return false;
  }
}
