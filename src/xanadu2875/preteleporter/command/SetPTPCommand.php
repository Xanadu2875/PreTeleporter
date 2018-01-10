<?php

namespace xanadu2875\preteleporter\command;

use pocketmine\command;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\level\Position;

class SetPTPCommand extends command\PluginCommand
{
  public function __construct(Plugin $owner)
  {
    parent::__construct("setptp", $owner);
    $this->setPermission("preteleporter.command.setptp");
    $this->setPermissionMessage("権限がありません");
    $this->setDescription("PTPに名前をつけて設定します");
    $this->setUsage("/setptp <name>\nExample: /setptp ロビー");
    $this->setAliases(["sptp"]);
  }

  public function execute(command\CommandSender $sender, string $commandLabel, array $args): bool
  {
    if(isset($args[0]))
    {
      if($sender instanceof Player)
      {
        if(!$this->getPlugin()->addPTP($args[0], $sender->getPosition()))
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
        if($level = $this->getPlugin()->getServer()->getLevelByName($args[4]))
        {
          if(!$this->getPlugin()->addPTP($args[0], new Position((int)$args[1], (int)$args[2], (int)$args[3], $level)))
          {
            $sender->sendMessage("登録がキャンセルされました。その名前は既に登録されています");
          }
        }
        else
        {
          $sender->sendMessage("存在しないワールドです");
        }
      }
      $sender->sendMessage("登録しました");
      return true;
    }
    return false;
  }
}
