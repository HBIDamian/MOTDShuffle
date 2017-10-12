<?php
namespace MOTDShuffle;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

class SendMOTD extends PluginTask{
    private $plugin;
    
    public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->line = -1;
    }
    
    public function onRun($tick){
        if ($this->getPlugin()->getMainConfig()->get("MOTD Shuffle") == "on"){
            //Shuffle is on
            $getMOTD = $this->getPlugin()->getMainConfig()->get("MOTD Message");
            $msg = $getMOTD[mt_rand(0, count($getMOTD) - 1)];      
            $this->plugin->getServer()->getNetwork()->setName($msg); 
        } elseif ($this->getPlugin()->getMainConfig()->get("MOTD Shuffle") == "off"){
            //Shuffle is off. 
            $getMOTD = $this->getPlugin()->getMainConfig()->get("MOTD Message");    
            $this->line++;
            $msg = $getMOTD[$this->line];
            $this->plugin->getServer()->getNetwork()->setName($msg);
            if($this->line === count($getMOTD) - 1){
                $this->line = -1;
            }
        } else {
            //Error if user didn't specify "On or Off"
            $this->getPlugin()->getLogger()->error("A error has occured! Make sure the setting is right in the §cconfig.yml§4.");
            $this->getPlugin()->getServer()->getScheduler()->cancelTask($this->getTaskId()); //Cancelled to prevent console spam ;)
        }
    }
    
    public function getPlugin(){
	   return $this->plugin;
    }
}