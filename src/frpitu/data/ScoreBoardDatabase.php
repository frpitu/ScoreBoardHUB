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

namespace frpitu\data;

use pocketmine\utils\Config;

use pocketmine\Player;

use frpitu\ScoreBoardHUB;

use \SQLite3;

final class ScoreBoardDatabase
{

	/** @var ScoreBoardHUB */
	private $source;

	/** @var SQLite3 */
	private $sqlite3;

	public function __construct(ScoreBoardHUB $source)
	{
		$this->source = $source;
	}

	public function initData()
	{
		$pluginDataFolder = $this->source->getDataFolder();
		if (!@mkdir($pluginDataFolder) && !file_exists($pluginDataFolder . 'preferences.db'))
		{
			$this->sqlite3 = new SQLite3($pluginDataFolder . 'preferences.db', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		} else {
			$this->sqlite3 = new SQLite3($pluginDataFolder . 'preferences.db', SQLITE3_OPEN_READWRITE);
		}
		$this->createPreferenceTable();
	}

	/**
	 * @return SQLite3
	 */
	public function getSQLite3() : SQLite3
	{
		return $this->sqlite3;
	}

	protected function createPreferenceTable()
	{
		$this->sqlite3->exec
		(
			'
			CREATE TABLE IF NOT EXISTS preferences
			(
				name VARCHAR(16) PRIMARY KEY NOT NULL,
				active INT NOT NULL
			);
			'
		);
	}

	/**
	 * @param Player $player
	 */
	public function newIndex(Player $player)
	{
		$stmt = $this->sqlite3->prepare('INSERT INTO preferences (name, active) VALUES (:name, :active);');
		$stmt->bindValue(':name', $player->getName(), SQLITE3_TEXT);
		$stmt->bindValue(':active', 0, SQLITE3_INTEGER);
		$stmt->execute();
	}

	/**
	 * @param Player $player
	 * @return bool
	 */
	public function existsIndex(Player $player) : bool
	{
		$stmt = $this->sqlite3->prepare('SELECT * FROM preferences WHERE name = :name');
		$stmt->bindValue(':name', $player->getName(), SQLITE3_TEXT);
		$res = $stmt->execute();

		if (!$res)
		{
			return false;
		}

		$array = $res->fetchArray(SQLITE3_ASSOC);
		return isset($array['name']) && $array['name'] === $player->getName();
	}

	/**
	 * @param Player $player
	 * @param bool $bool
	 */
	public function writeScoreboardBool(Player $player, bool $bool)
	{
		if (!$this->existsIndex($player))
		{
			$this->newIndex($player);
		}

		$stmt = $this->sqlite3->prepare('UPDATE preferences SET active = :active WHERE name = :name');
		$stmt->bindValue(':active', (int)$bool, SQLITE3_INTEGER);
		$stmt->bindValue(':name', $player->getName(), SQLITE3_TEXT);
		$stmt->execute();
	}

	/**
	 * @param Player $player
	 * @return bool
	 */
	public function getScoreboardBool(Player $player) : bool
	{
		if (!$this->existsIndex($player))
		{
			$this->newIndex($player);
		}

		$stmt = $this->sqlite3->prepare('SELECT * FROM preferences WHERE name = :name');
		$stmt->bindValue(':name', $player->getName(), SQLITE3_TEXT);
		$res = $stmt->execute();
		$array = $res->fetchArray(SQLITE3_ASSOC);

		return (bool)($array['active'] ?? 0);
	}
}
