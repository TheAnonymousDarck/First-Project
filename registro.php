<?php 

if(isset($_POST)){

      //conexion a la base de datos
      require_once 'includes/conexion.php';

      //iniciar sesion 
      if(!isset($_SESSION)){
            session_start();
      }
      
      //recoger los valores del formulario de registro

      $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
      $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
      $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
      $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

      //Array de errores
      $errores = Array();

      //validar los datos antes de guardarlos en la base de datos

      //validar nombre
      if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
            $nombre_validado= true;
      }else {
            $nombre_validado = false;
            $errores['nombre'] = "el nombre no es valido";
      }

      //validar apellidos
      if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
            $apellidos_validado= true;
      }else {
            $apellidos_validado = false;
            $errores['apellidos'] = "los apellidos no es valido";
      }

      //validar email
      if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_validado= true;
      }else {
            $email_validado = false;
            $errores['email'] = "el email no es valido";
      }

      //validar la contraseña
      if(!empty($password)){
            $password_validado= true;
      }else {
            $password_validado = false;
            $errores['password'] = "la contraseña esta vacia";
      }

      $guardar_usuario = false;

      if(count($errores) == 0){
            $guardar_usuario = true;

            //CIFRAR CONTRASEÑA
            $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);
            
            //INSERTAR USUARIO EN LA TABLA DE USUARIOS EN LA BD
            $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE());" ;
            $guardar = mysqli_query($db, $sql);


            if($guardar){
                  $_SESSION['completado'] = "el registro se ha completado con exito";     
            }else{
                  $_SESSION['errores']['general'] = "Fallo al guardar usuario!";
            }
      }else{
            $_SESSION['errores'] = $errores;
      }
}
header('Location: index.php');
?>