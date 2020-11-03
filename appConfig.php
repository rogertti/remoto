<?php		
    #ini_set('display_errors', 'on');
    #ini_set('output_buffering', 4096);
    #ini_set('session.auto_start', 1);
    #ini_set('SMTP', 'smtp.embracore.com.br');
    #ini_set('smtp_port', 587);
    #error_reporting(0);
    session_start();
    date_default_timezone_set('America/Sao_Paulo');
    
    $cfg = array(
        'head_title'=>'Suporte Remoto',
        'login_title'=>'<strong>Suporte Remoto</strong>',
        'side_title'=>'Suporte Remoto'
    );
?>