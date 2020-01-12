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
     $this->getServer()->getLogger()->Info("Plugin Ini Dibuat Oleh AlvinMask");
     $plugin = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
     if(is_null($plugin)) {
      $this->getLogger()->info("Harap Pasang Plugin EconomyAPI");
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
     $form->setTitle("§f§lMenu BankUI");
     $form->setContent("§a* §oHarap pilih menu berikutnya§r§f!");
     $form->addButton("§0Transfer Money\n§f§oTap to open");
     $form->addButton("§0Check Saldo Money\n§f§oTap to open");
     $form->addButton("§0Melihat Money Player\n§f§oTap to open");
     $form->addButton("§0Player Top Money\n§f§oTap to open");
     $p->sendForm($form);
    }

    public function transferMoney(Player $p){
     $form = new CustomForm(function(Player $p, $result){
      if($result === null){
       return;
      }
      if(trim($result[0]) === ""){
       $p->sendMessage("§a* §oHarap isi nama player tujuan transfer money§r§f!");
       return;
      }
      if(trim($result[1]) === ""){
       $p->sendMessage("§a* §oHarap isi jumlah money yang ingin ditransfer§r§f!");
       return;
      }
      $this->getServer()->getCommandMap()->dispatch($p, "pay ".$result[0]." ".$result[1]);
     });
     $form->setTitle("§f§lMenu Transfer Money");
     $form->addInput("§e§oNama Tujuan§r§f:");
     $form->addInput("§e§oJumlah Money§r§f:");
     $p->sendForm($form);
    }

    public function seeMoney(Player $p){
     $form = new CustomForm(function(Player $p, $result){
      if($result === null){
       return;
      }
      $this->getServer()->getCommandMap()->dispatch($p, "seemoney ".$result[0]);
     });
     $form->setTitle("§f§lMenu Check Money Player");
     $form->addInput("§e§oNama Player§r§f:");
     $p->sendForm($form);
    }

}
