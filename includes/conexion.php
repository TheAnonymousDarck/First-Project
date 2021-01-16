<?php 
      //conexion
      $servidor = 'localhost';
      $usuario = 'root';
      $password = '';
      $basededatos = 'manga';

      $db = mysqli_connect($servidor, $usuario, $password, $basededatos);  

      mysqli_query($db, "SET NAMES 'utf-8'");

      //INICIAR LA SESION
      session_start();
