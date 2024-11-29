<?php

declare (strict_types = 1);

/*
.########..####.########.##.....##
.##.....##..##.....##....##.....##
.##.....##..##.....##....##.....##
.########...##.....##....##.....##
.##.........##.....##....##.....##
.##.........##.....##....##.....##
.##........####....##.....#######.

COPYRIGHT LUIZ GULHERME S. MUNHOZ (frpitu), ALL RIGHTS RESERVED
_________________________________________________

Twitter: @mechamopitu
Discord: frpitu#1085 | frpitu
_________________________________________________
*/

namespace frpitu\utils;

use pocketmine\Player;

use frpitu\ScoreBoardHUB;

use frpitu\utils\display\DisplayMananger;

use frpitu\utils\api\PurePermsAPI;

final class ScoreBoardManager
{

	/** @var ScoreBoardHUB */
	private $source;

	public function __construct(ScoreBoardHUB $source)
	{
		$this->source = $source;
	}

	/**
	 * @return ScoreBoardHUB
	 */
	final public function getMain() : ScoreBoardHUB
	{
		return $this->source;
	}

	/**
	 * @return DisplayManager
	 */
	final public function getDisplayManager() : DisplayMananger
	{
		return new DisplayMananger($this);
	}

	/**
	 * @return PurePermsAPI
	 */
	final public function getPurePermsAPI() : PurePermsAPI
	{
		return new PurePermsAPI($this);
	}

	/**
	 * @param Player $player
	 */
	public function enable(Player $player)
	{
		$this->source->getPlayerData()->writeScoreboardBool($player, true);
	}

	/**
	 * @param Player $player
	*/
	public function disable(Player $player)
	{
		$this->source->getPlayerData()->writeScoreboardBool($player, false);
	}

	/**
	 * @param Player $player
	 * @return bool
	 */
	public function isEnabled(Player $player): bool
	{
		return $this->source->getPlayerData()->getScoreboardBool($player);
	}

	/**
	 * @return array
	 */
	public function getScoreboardPlayers(): array
	{
		return $this->scoreboard;
	}

	/**
	 * @param Player $player
	 * @param array $scoreboard
	 */
	public function sendScore(Player $player, array $scoreboard)
	{
		$format = "";
		$add = str_repeat(" ", 73);

		foreach ($scoreboard as $line)
		{
			$format .= $add . $line . "§r\n";
		}

		$format .= str_repeat("§r\n", 3);
		$player->sendTip($format);
	}
}
?>