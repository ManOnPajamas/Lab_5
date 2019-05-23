<?php
class UsuarioModel
{
	private $pdo;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost:3306;dbname=acad', 'root', '');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		        
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM usuarios");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$vo = new Usuario();

				$vo->__SET('idusuario', $r->id);
				$vo->__SET('login', $r->Login);
				$vo->__SET('clave', $r->Clave);
				$vo->__SET('estado', $r->Estado);

				$result[] = $vo;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM usuarios WHERE id = ?");
			          

			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$vo = new Usuario();

			$vo->__SET('id', $r->id);
			$vo->__SET('Login', $r->Login);
			$vo->__SET('Clave', $r->Clave);
			$vo->__SET('Estado', $r->Estado);
			

			return $vo;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM usuarios WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Usuarios $data)
	{
		try 
		{
			$sql = "UPDATE usuarios SET 
						Login          = ?, 
						Clave        = ?,
						Estado            = ? 
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('Login'), 
					$data->__GET('Clave'), 
					$data->__GET('Estado'),
					$data->__GET('id')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Usuarios $data)
	{
		try 
		{
		$sql = "INSERT INTO usuarios (Login,Clave,Estado) 
		        VALUES (?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('Login'), 
				$data->__GET('Clave'), 
				$data->__GET('Estado')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}

?>