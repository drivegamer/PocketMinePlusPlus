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

namespace pocketmine\item;

use pocketmine\entity\Effect;

class GoldenApple extends Food{
	const NORMAL = 0;
	const ENCHANTED = 1;
	public $saturation = 4;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLDEN_APPLE, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getNameByMeta($meta){
		static $names = [self::NORMAL => "Golden Apple",self::ENCHANTED => "Enchanted Golden Apple",2 => "Unknown Apple"];
		return $names[$meta & 0x02];
	}

	public function getEffects(){
		return ($this->meta === self::NORMAL?[
					[Effect::getEffect(Effect::ABSORPTION)->setDuration(120 * 20), 1],
					[Effect::getEffect(Effect::REGENERATION)->setDuration(2 * 20)->setAmplifier(1), 1]]:
				($this->meta === self::ENCHANTED?[
					[Effect::getEffect(Effect::ABSORPTION)->setDuration(120 * 20), 1],
					[Effect::getEffect(Effect::REGENERATION)->setDuration(30 * 20)->setAmplifier(4), 1],
					[Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(5 * 60 * 20), 1],
					[Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setDuration(5 * 60 * 20), 1]]:
				[]));
	}
}