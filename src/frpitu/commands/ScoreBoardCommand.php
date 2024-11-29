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

namespace frpitu\commands;

use pocketmine\command\
{
	Command,
	CommandSender,
	CommandExecutor
};

use frpitu\ScoreBoardHUB;

final class ScoreBoardCommand implements CommandExecutor
{

	/** @var ScoreBoardHUB */
	private $source;

	public function __construct(ScoreBoardHUB $source)
	{
		$this->source = $source;
	}

	/**
	 * @inheritDoc
	 *
	 * @param CommandSender $sender
	 * @param Command $command
	 * @param mixed $label
	 * @param array $args
	 */
	public function onCommand
	(
		CommandSender $sender,
		Command $command,
		$label, array $args
	)
	{
		if (!isset($args[0]))
		{
			$sender->sendMessage(ScoreBoardHUB::PREFIX . ' Use: /scoreboard §f(on/off)');
			return;
		}

		switch ($args[0])
		{
			case 'on':
				$sb = $this->source->getScoreboardManager();
				if ($sb->isEnabled($sender))
				{
					$sender->sendMessage(ScoreBoardHUB::PREFIX . ' §cO ScoreBoard já está habilitado!');
					echo('Função de está habilitado');
					return;
				}

				$sender->sendMessage(ScoreBoardHUB::PREFIX . ' §fO ScoreBoard foi habilitado!');
				$sb->enable($sender);
				break;
			case 'off':
				$sb = $this->source->getScoreboardManager();
				if (!$sb->isEnabled($sender))
				{
					$sender->sendMessage(ScoreBoardHUB::PREFIX . ' §cO ScoreBoard já está desbilitado!');
					echo('Função de já está habilitado');
					return;
				}

				$sender->sendMessage(ScoreBoardHUB::PREFIX . ' §fO ScoreBoard foi desabilitado!');
				$sb->disable($sender);
				break;
		}
	}
}