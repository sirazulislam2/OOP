<?php
namespace App\Enums;

enum EmailStatus:int{
  case Queue  = 0;
  case Sent   = 1;
  case Failed  = 2;

  public function toString(){
    return match ($this) {
      self::Queue => 'InQueue',
      self::Sent => 'Sent',
      self::Failed => 'Failed',
    };
  }
}