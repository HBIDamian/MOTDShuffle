<?php
namespace HBIDamian\MOTDShuffle;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");        
        $this->getMainConfig = new Config($this->getdatafolder() . "config.yml", Config::YAML);
        if (is_int($this->getMainConfig()->get("MOTD Delay")) == true){
            $this->getScheduler()->scheduleRepeatingTask(new SendMOTD($this), $this->getMainConfig()->get("MOTD Delay"));
        } else {
            $this->getLogger()->warning("The value you entered in 'MOTD Delay' is not an integer. Please fix it.");
        } 
    }

    public function getMainConfig(){
        return $this->getMainConfig;
    }
}