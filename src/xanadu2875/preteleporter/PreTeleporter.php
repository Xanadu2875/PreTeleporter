<?php

/**
 * @author  Xanadu2875
 * @version 0.2.0
 */

namespace xanadu2875\preteleporter;

use RuinPray\ui\UI;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\level\Position;
use pocketmine\level\Level;

//　  ∧,,∧
//　(；`・ω・）　　｡･ﾟ･⌒）
//　/　　 ｏ━ヽニニフ))
//　しー-Ｊ

/**
 * PreTeleporter メインクラス
 */
class PreTeleporter Extends PluginBase implements event\Listener
{

  private static $plugin;

  private $co = [];

  public function onLoad(): void
  {
    self::$plugin = $this;

    @mkdir($this->getDataFolder(), 777);
    $this->co = (new Config($this->getDataFolder() . "Coordinate.json", Config::JSON))->getAll();
    if(!empty($this->co))
    {
      $this->co = array_values($this->co);
    }
    else{
      $this->co = [];
    }

    if(!$this->checkUpdata())
    {
      $this->getLogger()->notice("新しいバージョンがリリースされています！ ⇒ " . $this->getDescription()->getWebsite());
    }
  }

  public function onEnable()
  {
    $this->registerCommands();

    $this->getServer()->getPluginManager()->registerEvents($this, $this);

    $this->getLogger()->info("起動しました！");
    $this->getLogger()->info("改造OK、二次配布OK(plugin.ymlのauthorsプロパティにあなたの名前を追加してください。websiteプロパティの記述を変更してください)、自作発言禁止！");
  }

  public function onDisable()
  {
    $config = new Config($this->getDataFolder() . "Coordinate.json", Config::JSON);
    $config->setAll(array_values($this->co));
    $config->save();
  }

  public static function getInstance(): Plugin
  {
    return self::$plugin;
  }

  /**
   * registerCommands コマンドを登録する
   */
  private function registerCommands(): void
  {
    $map = $this->getServer()->getCommandMap();
    $commands = [
      "setptp" => "xanadu2875\preteleporter\command\SetPTPCommand",
      "delptp" => "xanadu2875\preteleporter\command\DeletePTPCommand",
      "ptp" => "xanadu2875\preteleporter\command\PTPCommand"
    ];
    foreach($commands as $cmd => $class)
    {
      $map->register("preteleporter", new $class($this));
    }
  }

  /**
   * checkUpdate アップデートがあるかチェックします
   * @return bool あったらtrue
   */
  private function checkUpdata() : bool { return str_replace("\n", "",Utils::getURL("https://raw.githubusercontent.com/Xanadu2875/VersionManager/master/PreTeleporter.txt" . '?' . time() . mt_rand())) === $this->getDescription()->getVersion(); }

  /**
   * sendTPTUI プレイヤーに項目をUIで送ります
   * @param Player $player 送るプレイヤー
   */
  public function sendPTPUI(Player $player): void
  {
    $this->co = array_values($this->co);

    $form = UI::createSimpleForm(2875);
    $form->setTitle("PreTeleporter");
    $form->setContent("テレポート先を選択してください");
    $form->addButton('やめる');
    foreach($this->co as $data)
    {
      if(isset($data["name"]))
      {
        $form->addButton($data["name"]);
      }
    }

    UI::sendForm($player, $form);
  }

  /**
   * addCo 座標を追加します
   * @param  array $array 座標が入った配列
   * @return bool         できたかどうか
   */
  public function addPTP(string $name, Position $pos): bool
  {
    foreach($this->co as $co) if($co['name'] === $name) return false;

    $this->co[] = ["name" => $name, "x" => $pos->x, "y" => $pos->y, "z" => $pos->z, "level" => $pos->getLevel()->getName()];

    return true;
  }

  public function deletePTP(string $name) : bool
  {
    foreach($this->co as $key => $co)
    {
      if($co["name"] === $name)
      {
        unset($this->co[$key]);
        $this->co = array_values($this->co);
        return true;
      }
    }

    return false;
  }

  public function onReceiveData(event\server\DataPacketReceiveEvent $event)
  {
    if(($pk = $event->getPacket()) instanceof ModalFormResponsePacket)
    {
      if($pk->formId === 2875)
      {
        $player = $event->getPlayer();
        $data = \json_decode($pk->formData);
        if($data == 0 && $data == null)
        {
          return;
        }
        else
        {
          if($co = $this->co[$data - 1])
          {
            $player = $event->getPlayer();
            if(isset($co['x']) && isset($co['y']) && isset($co['z']) && isset($co['level']))
            {
              if($level = $this->getServer()->getLevelByName($co['level']))
              {
                $player->teleport(new Position((int)$co['x'], (int)$co['y'], (int)$co['z'], $level));
                $player->sendMessage("{$co['name']}にテレポートしました");
              }
              else
              {
                $player->sendMessage("broken");
              }
            }
            else
            {
              $player->sendMessage("broken");
            }
          }
        }
      }
    }
  }
}
