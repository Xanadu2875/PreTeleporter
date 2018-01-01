# ![PreTeleporter](https://raw.githubusercontent.com/wiki/Xanadu2875/PreTeleporter/images/logo.png)
PMMPプラグインです(Written in PHP)

## Description

あらかじめ設定されている場所にFormを使ってテレポートできます。


## Download

### [![PMMP Forum JP](https://forum.pmmp.ga/assets/logo-8gp5x8ya.png)](https://forum.pmmp.ga/d/42-preteleporter)

## Demo

[YouTube](https://youtu.be/fnsHLgtt6SQ)

## PreTeleporter commands

| コマンド | パラメーター | 説明 | 権限 |
| :-----: | :---------: | :--: | :-: |
| /setptp | `<名前>` (`<x>` `<y>` `<z>` `<ワールドの名前>`) | 場所をセットします | OP |
| /ptp | | Formを送ります | `すべてのプレイヤー` |

## For Developers

`xanadu2875\preteleporter\PreTeleporter::getInstance()` でPreTeleporterの関数にアクセスできます。

例:
```PHP
use xanadu2875\preteleporter\PreTeleporter;
PreTeleporter::getInstance()->addCo($name, $x, $y, $z, $level);
```

### Functions

```php
PreTeleporter::addCo(string $name, int $x, int $y, int $z, pocketmine\level\Level $level): bool
PreTeleporter::sendTPTUI(Player $player): bool
```

## Author

Twitter
[@xanadu2875](https://twitter.com/xanadu2875)

Lobi
[1a8ca](https://web.lobi.co/user/1a8ca6d4fdd1d87e0f26c68e18f08de6413f7d36)

## License

GPLLv3
