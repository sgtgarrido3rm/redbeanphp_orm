<?php
if(isset($_GET['cod'])){
  if($_GET['cod'] == md5("1")){
    $msg = "<font color='#FFF' size='-1' >".MSG_ACESSO_NEGADO."</font>";
    $div = "<div class='alert alert-danger alert-dismissable'>";
  }

  if($_GET['cod'] == md5("2")){
    $msg = "<font color='#FFF' size='-1' >".MSG_ACESSO_NEGADO_BD."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("3")){
    $msg = "<font color='#FFF' size='-1' >".MSG_CONSULTA_VAZIA."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("4")){
    $msg = "<font color='#FFF' size='-1' >".MSG_USUARIO_SENHA."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("5")){
    $msg = "<font color='#FFF' size='-1' >".MSG_ERRO_GRAVAR_BD."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("6")){
    $msg = "<font color='#0000FF' size='-1' >".MSG_SUCESSO."</font>";
    $div = "<div class='alert alert-success alert-dismissable'>";    
  }

  if($_GET['cod'] == md5("7")){
    $msg = "<font color='#FFF' size='-1' >".MSG_CPF_INVALIDO."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("8")){
    $msg = "<font color='#FFF' size='-1' >".MSG_ERRO_EMAIL."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("9")){
    $msg = "<font color='#FFF' size='-1' >".MSG_LOGOFF_SUCESSO."</font>";
    $div = "<div class='alert alert-success alert-dismissable'>";
  }

  if($_GET['cod'] == md5("10")){
    $msg = "<font color='#FFF' size='-1' >".MSG_ATUALIZACAO_SUCESSO."</font>";
    $div = "<div class='alert alert-warning alert-dismissible'>";
  }

  if($_GET['cod'] == md5("11")){
    $msg = "<font color='#FFF' size='-1' >".MSG_EXCLUIR_SUCESSO."</font>";
    $div = "<div class='alert alert-danger alert-dismissible'>";
  }
}
?>