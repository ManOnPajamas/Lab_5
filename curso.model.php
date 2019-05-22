<?php
class cursoModel
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

			$stm = $this->pdo->prepare("SELECT * FROM curso");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$vo = new curso();

				$vo->__SET('codigo', $r->codigo);
				$vo->__SET('nombre', $r->nombre);
				$vo->__SET('creditos', $r->creditos);
				

				$result[] = $vo;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($codigo)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM curso WHERE codigo = ?");
			          

			$stm->execute(array($codigo));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$vo = new curso();

			$vo->__SET('codigo', $r->codigo);
			$vo->__SET('nombre', $r->nombre);
			$vo->__SET('creditos', $r->creditos);
			
			return $vo;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($codigo)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM curso WHERE codigo = ?");			          

			$stm->execute(array($codigo));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(curso $data)
	{
		try 
		{
			$sql = "UPDATE curso SET 
						nombre          = ?, 
						creditos        = ?
						
				    WHERE codigo = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre'), 
					$data->__GET('creditos'), 
					$data->__GET('codigo')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(curso $data)
	{
		try 
		{
		$sql = "INSERT INTO curso (nombre,creditos) 
		        VALUES (?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre'), 
				$data->__GET('creditos') 
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}