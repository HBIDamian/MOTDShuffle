<?php
namespace MOTDShuffle;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

class SendMOTD extends PluginTask{
    private $plugin;
    
    public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    
    public function onRun($tick){
        $getMOTD = $this->getPlugin()->getMainConfig()->get("MOTD Message");
        $getMOTDArray = $getMOTD[mt_rand(0, count($getMOTD) - 1)];      
        $this->plugin->getServer()->getNetwork()->setName($getMOTDArray);            
    }
    
    public function getPlugin(){
	   return $this->plugin;
    }
}