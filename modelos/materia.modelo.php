<?php



require_once "conexion.php";


class ModeloMateria
{

	static public function mdlMostrarMateria($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();
		}



		$stmt = null;
	}



	/*=============================================
MUESTRA TODAS LAS MATERIAS APROBADAS DEL ESTUDIANTE  
=============================================*/
	static public function mdlMostrarMatriasTodasEstudiante($tabla, $item, $valor)
	{

		/* $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2 ");

		
	$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_INT);
	$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();*/

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $item ASC ");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();
	}

	/*=============================================
MUESTRA TODAS LAS MATERIAS APROBADAS DEL ESTUDIANTE 
=============================================*/
	static public function mdlMostrarMatriasAprobadasEstudiante($tabla, $item1, $valor1, $item2, $valor2)
	{



		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2 ");


		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_INT);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_INT);



		$stmt->execute();

		return $stmt->fetchAll();
	}

	/*=============================================
MUESTRA TODAS LAS MATERIAS MATRICULADAS DEL ESTUDIANTE 
=============================================*/
	static public function mdlMostrarMatriasMatriculadasEstudiante($tabla, $item1, $valor1, $item2, $valor2)
	{



		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2 ");


		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_INT);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_INT);



		$stmt->execute();

		return $stmt->fetchAll();
	}
	/*=============================================
MUESTRA TODAS LAS MATERIAS PENDIENTES
=============================================*/
	static public function mdlMostrarMateriasEstudiante($tabla, $item1, $valor1, $item2, $valor2)
	{


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2 ");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_INT);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();
	}
}
