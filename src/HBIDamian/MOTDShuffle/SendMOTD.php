<?php
namespace HBIDamian\MOTDShuffle;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

class SendMOTD extends Task {

    private Main $plugin;
	private int $line;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->line = -1;
    }

    public function replaceVars(string $str, array $vars): string{
	foreach ($vars as $key => $value){
	    $str = str_replace('{' . $key . '}', (string) $value, $str);
	}
	return $str;
    }

    public function onRun(): void{
        $getMOTD = $this->getPlugin()->getMainConfig()->get("MOTD Message");
        $replaceArray = [
            'POCKETMINE_API' => $this->plugin->getServer()->getApiVersion(),
            'SERVER_VERSION' => $this->plugin->getServer()->getVersion(),
            'ONLINE_PLAYERS' => count($this->plugin->getServer()->getOnlinePlayers()),
            'MAX_PLAYERS' => $this->plugin->getServer()->getMaxPlayers(),           
            'PREFIX' => $this->getPlugin()->getMainConfig()->get("Prefix"),
            'SUFFIX' => $this->getPlugin()->getMainConfig()->get("Suffix")
        ];

        if ($this->getPlugin()->getMainConfig()->get("MOTD Shuffle") == "on"){
            //Shuffle is on
            $msg = $getMOTD[mt_rand(0, count($getMOTD) - 1)];
            $this->plugin->getServer()->getNetwork()->setName(TextFormat::colorize($this->replaceVars($msg, $replaceArray)));

        } elseif ($this->getPlugin()->getMainConfig()->get("MOTD Shuffle") == "off"){
            //Shuffle is off. 
            $this->line++;
            $msg = $getMOTD[$this->line];
            $this->plugin->getServer()->getNetwork()->setName(TextFormat::colorize($this->replaceVars($msg, $replaceArray)));
            if($this->line === count($getMOTD) - 1){
                $this->line = -1;
            }
        } else {
            //Error if user didn't specify "On or Off"
            $this->getPlugin()->getLogger()->error("A error has occured! Make sure the setting is right in the §cconfig.yml§4.");
	    $this->getHandler()->cancel(); //Cancelled to prevent console spam ;)
        }
    }
    
    public function getPlugin() : Main{
	return $this->plugin;
    }
}