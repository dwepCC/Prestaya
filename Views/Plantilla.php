<?php

if(isset($_GET["url"])){
  if($_GET["url"]=="dashboard"
  ||$_GET["url"]=="users"
  ||$_GET["url"]=="salir"
  ||$_GET["url"]=="category"
  ||$_GET["url"]=="product"
  ||$_GET["url"]=="supplier"
  ||$_GET["url"]=="customer"
  ||$_GET["url"]=="blacklist"
  ||$_GET["url"]=="newsale"
  ||$_GET["url"]=="newloan"
  ||$_GET["url"]=="listsales"
  ||$_GET["url"]=="generalsetting"
  ||$_GET["url"]=="vouchersetting"
  ||$_GET["url"]=="paymentstype"
  ||$_GET["url"]=="datebuy"
  ||$_GET["url"]=="clientdatesales"
  ||$_GET["url"]=="permissions"
  ||$_GET["url"]=="buy"
  ||$_GET["url"]=="graphics"
  ||$_GET["url"]=="editsale"
  ||$_GET["url"]=="editbuy"
  ||$_GET["url"]=="salesproduct"
  ||$_GET["url"]=="purchaseproduct"  
  ||$_GET["url"]=="kardex"
  ||$_GET["url"]=="desembolso"
  ||$_GET["url"]=="autoriza"
  ||$_GET["url"]=="cuadrecaja"
  ||$_GET["url"]=="pagocredito"
  ||$_GET["url"]=="garantias"
  ||$_GET["url"]=="aventa"
  ||$_GET["url"]=="egreso"
  ||$_GET["url"]=="ingreso"
  ||$_GET["url"]=="cuenta"
  ||$_GET["url"]=="ahorro"
  ||$_GET["url"]=="dpahorro"
  ||$_GET["url"]=="plazofijo"
  ||$_GET["url"]=="dplazo"
  ||$_GET["url"]=="enrep"
  ||$_GET["url"]=="henrep"
  ||$_GET["url"]=="estadof"
  || $_GET["url"]=="login"){
      include "modules/".$_GET["url"].".php";
  }else{
      include "modules/404.php";
  }
}else{
   include "modules/login.php";
}