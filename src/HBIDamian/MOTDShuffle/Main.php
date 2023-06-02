<?php
namespace HBIDamian\MOTDShuffle;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    private Config $getMainConfig;

    public function onEnable(): void {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");        
        $this->getMainConfig = new Config($this->getdatafolder() . "config.yml", Config::YAML);
        $configVersion = "1.0.0";
        if (is_int($this->getMainConfig()->get("MOTD Delay"))){
            if ($this->getMainConfig->get("Config Version") !== $configVersion){
                $this->getLogger()->error("The config version is invalid. Please update the config.yml.");
            } else {
                $this->getScheduler()->scheduleRepeatingTask(new SendMOTD($this), $this->getMainConfig()->get("MOTD Delay"));
            }
        } else {
            $this->getLogger()->error("The value you entered in 'MOTD Delay' is not an integer. Please fix it.");
        } 
    }

    public function getMainConfig() : Config{
        return $this->getMainConfig;
    }
}