<?php

namespace PlayerPosition\Commands;

use PlayerPosition\Utils\Message\MessageFormatter as Message;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use SmartCommand\command\argument\PlayerArgument;
use SmartCommand\command\CommandArguments;
use SmartCommand\command\rule\defaults\OnlyInGameCommandRule;
use SmartCommand\command\SmartCommand;
use SmartCommand\message\CommandMessages;

class PositionCommand extends SmartCommand
{

    public function __construct()
    {
        parent::__construct(
            'position',
            'Get the position of player',
            SmartCommand::DEFAULT_USAGE_PREFIX,
            ['pos']
        );
    }

    protected static function getRuntimePermission(): string
    {
        return 'position.command';
    }

    protected function prepare()
    {
        $this->registerRule(new OnlyInGameCommandRule);
        $this->registerArgument(0, new PlayerArgument('target', PlayerArgument::SEARCH_FROM_PREFIX, false));
    }

    protected function onRun(CommandSender $sender, string $label, CommandArguments $args)
    {
        $target = null;
        $player = $sender;

        if ($args->has('target')) 
        {
            $target = $args->getPlayer('target');
        }

        if ($target instanceof Player) 
        {
            $position = $target->getPosition();

            $message = new Message("§c» §fPosition of {player_name}'s: §ex=§f{x} §ey=§f{y} §ez=§f{z} §eworld=§f{level}");
            
            $message->setFormat('player_name', $target->getName());
            $message->setFormat('x', (string) $position->getX());
            $message->setFormat('y', (string) $position->getY());
            $message->setFormat('z', (string) $position->getZ());
            $message->setFormat('level', (string) $position->getLevel()->getName());

            $message->send($player, false);

            return;
        }

        $position = $player->getPosition();

        $message = new Message('§c» §fYour position: §ex=§f{x} §ey=§f{y} §ez=§f{z} §eworld=§f{level}');

        $message->setFormat('x', (string) $position->getX());
        $message->setFormat('y', (string) $position->getY());
        $message->setFormat('z', (string) $position->getZ());
        $message->setFormat('level', (string) $position->getLevel()->getName());

        $message->send($player, false);
    }
}
