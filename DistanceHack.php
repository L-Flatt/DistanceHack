<?php

/**
 * @name DistanceHack
 * @main DistanceHack\Main
 * @author BLEAN
 * @version 1.0
 * @api 4.0.0
 */

namespace DistanceHack;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\Player;

class Main extends \pocketmine\plugin\PluginBase implements \pocketmine\event\Listener{

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	* @param EntityDamageEvent $event
	*
	* @priority LOWEST
	*/
	public function onDamage(EntityDamageEvent $event){
		if (!$event instanceof EntityDamageByEntityEvent)
			return true;
		if (!$event->getDamager() instanceof Player)
			return true;
		if (!$event->getEntity() instanceof Player)
			return true;
		if ($event->getCause() === EntityDamageEvent::CAUSE_PROJECTILE)
			return true;
		if ($event->getEntity()->distanceSquared($event->getDamager()) > 20){
			$this->getLogger()->info($event->getDamager()->getName() . ', 사거리 ' . (int) ($event->getEntity()->distanceSquared($event->getDamager()) / 4) . ' 블럭');
			$event->getDamager()->sendPopUp('§c사거리 핵 감지로 캔슬 되었습니다');
			$event->setCancelled();
		}
	}
}
