<?php

declare(strict_types = 1);

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

namespace frpitu\tasks;

use pocketmine\scheduler\Task;

use pocketmine\Server;

use frpitu\ScoreBoardHUB;

final class ScoreBoardTask extends Task
{
	/** @var ScoreBoardHUB */
	private $source;

	/** @var int */
	private $currentAnimationFrame = 0;

	public function __construct(ScoreBoardHUB $source)
	{
		$this->source = $source;
	}

	/**
	 * @param int $ticks
	 */
	public function onRun($ticks)
	{
		$sb = $this->source->getScoreboardManager();
		foreach (Server::getInstance()->getOnlinePlayers() as $players)
		{
			if ($sb->isEnabled($players))
			{
				$prefixAnimation =
				[
					'§l§bH§fUBSKY§r',
					'§l§bHU§fBSKY§r',
					'§l§bHUB§fSKY§r',
					'§l§bHUBS§fKY§r',
					'§l§bHUBSK§fY§r',
					'§l§bHUBSKY§r',
					'§l§fH§bUBSKY§r',
					'§l§fHU§bBSKY§r',
					'§l§fHUB§bSKY§r',
					'§l§fHUBS§bKY§r',
					'§l§fHUBSK§bY§r',
					'§l§fHUBSKY§r'
				];

				$prefix = $prefixAnimation[$this->currentAnimationFrame];

				$this->currentAnimationFrame = ($this->currentAnimationFrame + 1) % count($prefixAnimation);

				$display = $sb->getDisplayManager();
				$o = $display->getOnlinePlayers();
				$c = $display->getPlayersInLobby($players->getLevel()->getName());
				$tag = $display->getTag($players);
				$date = $display->getDate();
				$name = $display->getPlayerName($players);

				$scoreboard = array
				(
					$prefix . ' §8(' . $date . '§8)',
					'§bSeu nome: §f' . $name,
					'§bSua tag: §f' . $tag,
					'§7-------------------------------',
					'§bJogadores(as) online: §f' . $o,
					'§bJogadores(as) no lobby: §f' . $c,
					'§7-------------------------------',
				);

				$sb->sendScore($players, $scoreboard);
			}
		}
	}
}
