<?php
    include "../conexion.php";
    if(!empty($_post))
    {
           $alert='';
           if(empty($_post['nombre'])||empty($_post['correo'])||empty($_post['usuario'])||empty($_post['clave'])||empty($_post['rol']))
           {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
           }else{

                $nombre = $_post['nombre'];
                $email = $_post['correo'];
                $user = $_post['usuario'];
                $clave = md5($_post['clave']);
                $rol = $_post['rol'];

                $query = mysqli_query($conection,"SELECT * FROM usuario WHERE USUARIO = '$user' OR correo = '$email' ");
                $result=mysqli_fetch_array($query);

                if($result > 0){
                    $alert= '<p class="msg_error">El usuario o el correo ya existe.</p> ';    
                }else{
                    $query_insert=mysqli_query($conection,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
                        VALUES('nombre','email','user','clave','rol')");
                }
                if($query_insert){
                    $alert='<p class="msg_save">Usuario creado exitosamente.</p> '; 
                }else{
                    $alert='<p class="msg_error">Error al crear el usuario.</p> ';
                }
            }
    }
    //Mostrar datos
    if(empty($_GET['id']))
    {
        header('location: lista_usuarios.php');
    } 
    $iduser = $_GET['id'];
    $sql = mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) AS idrol, (r.rol) AS rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE idusuario = $iduser");
    $result_sql = mysqli_num_rows($sql);
    if($result_sql == 0){
        header('location: lista_usuarios.php');        
    }else{
        while ($data = mysqli_fetch_array($sql)) {
            # code...
            $iduser = $data['idusuario'];
            $nombre = $data['nombre'];
            $correo = $data['correo'];
            $usuario = $data['usuario'];
            $idrol = $data['idrol'];
            $rol = $data['rol'];
        }
    }             
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include"includes/scripts.php";?>
	<title>Actualizar Usuario</title>
</head>
<body>
	<?php include"includes/header.php";?>
	<section id="container">
        <div class="form_register">
            <h1>Actualizar usuario</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>
            <form action="" method="poss">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
                <label for="correo">Correo electronico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electronico">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">
                <label for="rol">Tipo de usuario</label>
            <?php
                $query_rol=mysqli_query($conection,"SELECT * FROM rol");
                $result_rol=mysqli_num_rows($query_rol); 
            ?>
                <select name="rol" id="rol">
            <?php 
                if($result_rol > 0)
                {
                while($rol=mysqli_fetch_array($query_rol)){
            ?>        
                <option value="<?php echo $rol ["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
            <?php    
                        # code...
                   }     
                }                      
            ?>        
                </select>
                <input type="submit" value="Actualizar usuario" class="btn_save">                                             
            </form>
        </div>
	</section>

	<?php include"includes/footer.php";?>

</body>
</html>