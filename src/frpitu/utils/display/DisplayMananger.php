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

namespace frpitu\utils\display;

use pocketmine\Player;

use pocketmine\Server;

use frpitu\utils\ScoreBoardManager;

final class DisplayMananger
{

	/** @var ScoreBoardManager */
	private $source;

	public function __construct(ScoreBoardManager $source)
	{
		$this->source = $source;
	}

	/**
	 * @return Server
	 */
	public function getServer() : Server
	{
		return Server::getInstance();
	}

	/**
	 * @return int
	 */
	public function getOnlinePlayers() : int
	{
		return count($this->getServer()->getOnlinePlayers());
	}

	/**
	 * @param Player $player
	 * @return string
	 */
	public function getPlayerName(Player $player) : string
	{
		return $player->getName();
	}

	/**
	 * @param string $levelName
	 * @return int
	 */
	public function getPlayersInLobby(string $levelName) : int
	{
		return count($this->getServer()->getLevelByName($levelName)->getPlayers());
	}

	/**
	 * @param Player $player
	 * @return string
	 */
	public function getTag(Player $player)
	{
		$tag = $this->source->getPurePermsAPI()->getPlugin();
		$group = $tag->getUserDataMgr()->getGroup($player);
		return $group->getName();
	}

	public function getDate()
	{
		return date('d/m/Y');
	}
}