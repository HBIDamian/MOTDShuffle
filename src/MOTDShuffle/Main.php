<?php
namespace MOTDShuffle;

use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");        
        $this->getMainConfig = new Config($this->getdatafolder() . "config.yml", Config::YAML);
        $this->getLogger()->info("has been activated!");
        if (is_int($this->getMainConfig()->get("MOTD Delay")) == true){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new SendMOTD($this), $this->getMainConfig()->get("MOTD Delay"));
        } else {
            $this->getLogger()->info("§4The value you entered in §c'MOTD Delay' §4is not an integer. Please fix it.");
        } 
    }

    public function getMainConfig(){
        return $this->getMainConfig;
    }
}