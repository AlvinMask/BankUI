<?php

namespace AlvinMask\BankUI;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

use AlvinMask\BankUI\Form\SimpleForm;
use AlvinMask\BankUI\Form\CustomForm;

class Main extends PluginBase{

    public function onEnable(){
     $this->getServer()->getLogger()->Info("Plugin Made by AlvinMask");
     $plugin = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
     if(is_null($plugin)){
      $this->getLogger()->info("Please Put EconomyAPI Plugin");
      $this->getServer()->shutdown();
     }
    }

    public function onCommand(CommandSender $p, Command $commad, string $label, array $args):bool{
     switch($commad->getName()){
      case "bankui":{
       if($p instanceof Player){
        $this->menuBank($p);
        break;
       }else{
        $p->sendMessage("§a* §oHarap gunakan command ini di dalam game§r§f!");
       }
      }
     }
     return true;
    }

    public function menuBank(Player $p){
     $form = new SimpleForm(function(Player $p, $result){
      if($result === null){
       return;
      }
      switch($result){
       case 0:{
        $this->transferMoney($p);
        break;
       }
       case 1:{
        $this->getServer()->getCommandMap()->dispatch($p, "mymoney");
        break;
       }
       case 2:{
        $this->seeMoney($p);
        break;
       }
       case 3:{
        $this->getServer()->getCommandMap()->dispatch($p, "topmoney");
        break;
       }
      }
     });
     $form->setTitle("§f§lBankUI Menu");
     $form->setContent("§a* §oPlease choose the next menu§r§f!");
     $form->addButton("§0Transfer money to player\n§f§oTap to open");
     $form->addButton("§0See your money\n§f§oTap to open");
     $form->addButton("§0Look player money\n§f§oTap to open");
     $form->addButton("§0List player Top Money\n§f§oTap to open");
     $p->sendForm($form);
    }

    public function transferMoney(Player $p){
     $form = new CustomForm(function(Player $p, $result){
      if($result === null){
       return;
      }
      if(trim($result[0]) === ""){
       $p->sendMessage("§a* §oPlease fill in the name of the player for the money transfer destination§r§f!");
       return;
      }
      if(trim($result[1]) === ""){
       $p->sendMessage("§a* §oPlease fill in the amount of money you want to transfer§r§f!");
       return;
      }
      $this->getServer()->getCommandMap()->dispatch($p, "pay ".$result[0]." ".$result[1]);
     });
     $form->setTitle("§f§lTransfer Money Menu");
     $form->addInput("§e§oDestination Name§r§f:");
     $form->addInput("§e§oAmount of Money§r§f:");
     $p->sendForm($form);
    }

    public function seeMoney(Player $p){
     $form = new CustomForm(function(Player $p, $result){
      if($result === null){
       return;
      }
      $this->getServer()->getCommandMap()->dispatch($p, "seemoney ".$result[0]);
     });
     $form->setTitle("§f§lSee Player Menu");
     $form->addInput("§e§oDestination Name§r§f:");
     $p->sendForm($form);
    }

}
