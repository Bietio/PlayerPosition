<?php

namespace PlayerPosition;

use PlayerPosition\Commands\PositionCommand;
use pocketmine\plugin\PluginBase;
use SmartCommand\api\SmartCommandAPI;

class Loader extends PluginBase
{

    public function onEnable()
    {
        SmartCommandAPI::register('position', new PositionCommand());        
    }
    
}
