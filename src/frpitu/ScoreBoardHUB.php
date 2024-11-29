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

namespace frpitu;

use pocketmine\plugin\PluginBase;

use frpitu\tasks\ScoreBoardTask;

use frpitu\commands\ScoreBoardCommand;

use frpitu\utils\ScoreBoardManager;

use frpitu\listener\ScoreBoardListener;

use frpitu\data\ScoreBoardDatabase;


final class ScoreBoardHUB extends PluginBase
{

	const PREFIX = '§b§lScoreBoard§r';

	/** @var ScoreBoardDatabase */
	public $sqlite3;

	/**
	 * @inheritDoc
	 */
	public function onEnable()
	{
		$info =
		[
			str_repeat('§b_§f_', 16),
			'§bScoreBoard§fHUB §7(frpitu)',
			'§bTwitter: §f@mechamopitu',
			'§bGithub: §fhttps://github.com/frpitu',
			str_repeat('§b_§f_', 16)
		];

		foreach ($info as $msg)
		{
			$this->getLogger()->info($msg);
		}

		$this->sqlite3 = new ScoreBoardDatabase($this);
		$this->sqlite3->initData();

		$this->getServer()->getScheduler()->scheduleRepeatingTask(new ScoreBoardTask($this), 10);
		$this->getCommand('scoreboard')->setExecutor(new ScoreBoardCommand($this));
		$this->getServer()->getPluginManager()->registerEvents(new ScoreBoardListener($this), $this);
	}

	/**
	 * @return ScoreBoardManager
	 */
	final public function getScoreboardManager() : ScoreBoardManager
	{
		return new ScoreBoardManager($this);
	}

	final public function getPlayerData() : ScoreBoardDatabase
	{
		return $this->sqlite3;
	}
}
