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

namespace frpitu\listener;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerLoginEvent;

use pocketmine\event\entity\EntityTeleportEvent;

use pocketmine\Player;

use frpitu\ScoreBoardHUB;

final class ScoreBoardListener implements Listener
{

	/** @var ScoreBoardHUB */
	private $source;

	public function __construct(ScoreBoardHUB $source)
	{
		$this->source = $source;
	}

	/**
	 * @param PlayerJoinEvent $event
	 *
	 * @priority LOW
	 */
	public function join(PlayerLoginEvent $event)
	{
		if (!$this->source->getPlayerData()->existsIndex($event->getPlayer())) $this->source->getPlayerData()->newIndex($event->getPlayer());
		$this->source->getScoreboardManager()->enable($event->getPlayer());
	}

	/**
	 * @param EntityTeleportEvent $event
	 *
	 * @priority LOW
	 */
	public function teleport(EntityTeleportEvent $event)
	{
		$entity = $event->getEntity();
		if ($entity instanceof Player and $entity->getLevel()->getName() != $this->source->getServer()->getDefaultLevel()->getName())
		{
			$this->source->getScoreboardManager()->disable($entity);
		}
	}
}
