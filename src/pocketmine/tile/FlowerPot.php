<?php

/*                                                                             __
 *                                                                           _|  |_
 *  ____            _        _   __  __ _                  __  __ ____      |_    _|
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \    __ |__|  
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) | _|  |_  
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ |_    _|
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|      |__|   
 *
 * This program is free software: you can redistribute it and/or modify 
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine++ Team
 * @link http://pm-plus-plus.tk/
*/

namespace pocketmine\tile;

use pocketmine\block\Block;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\Short;
use pocketmine\nbt\tag\String;
use pocketmine\tile\Tile;

class FlowerPot extends Spawnable{

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->item)){
			$nbt->item = new Short("item", 0);
		}
		if(!isset($nbt->data)){
			$nbt->data = new Int("data", 0);
		}
		parent::__construct($chunk, $nbt);
	}

	public function getFlowerPotItem(){
		return $this->namedtag["item"];
	}

	public function getFlowerPotData(){
		return $this->namedtag["data"];
	}

	/**
	 *
	 * @param int $item        	
	 * @param int $data        	
	 */
	public function setFlowerPotData($item, $data){
		$this->namedtag->item = new Short("item", (int) $item);
		$this->namedtag->data = new Int("data", (int) $data);
		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
			$block = $this->level->getBlock($this);
			if($block->getId() === Block::FLOWER_POT_BLOCK){
				$this->level->setBlock($this, Block::get(Block::FLOWER_POT_BLOCK, $data), \true, \true);
			}
		}
		return \true;
	}

	public function getSpawnCompound(){
		return new Compound("", [
			new String("id", Tile::FLOWER_POT),
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z),
			new Short("item", (int) $this->namedtag["item"]),
			new Int("data", (int) $this->namedtag["data"])
		]);
	}
}