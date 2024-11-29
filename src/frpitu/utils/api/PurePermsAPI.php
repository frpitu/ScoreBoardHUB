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

namespace frpitu\utils\api;

use frpitu\utils\ScoreBoardManager;

final class PurePermsAPI
{

	private $source, $plugin;

	public function __construct(ScoreBoardManager $source)
	{
		$this->source = $source;
		$this->plugin = $source->getMain()->getServer()->getPluginManager()->getPlugin('PurePerms');
	}

	public function getPlugin()
	{
		return $this->plugin;
	}

	public static function hasPlugin() : bool
	{
		return $this->plugin ?? null;
	}
}