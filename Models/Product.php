<?php 
//incluir la conexion de base de datos 
require_once "Connect.php";
class Product{

    private $tableName='articulo';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion(); 
	}

	//metodo insertar regiustro
    public function insertar($idcategoria,$tipo_articulo,$codigo,$nombre,$marca,$modelo,$stock,$metal,$peso,$pureza,$kilometraje,$descripcion,$evaluo,$valor_prestamo,$precio_venta,$imagen){
        $sql="INSERT INTO $this->tableName (idcategoria,tipo_articulo,codigo,nombre,marca,modelo,stock,metal,peso,pureza,kilometraje,descripcion,evaluo,valor_prestamo,precio_venta,imagen,condicion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idcategoria,$tipo_articulo,$codigo,$nombre,$marca,$modelo,$stock,$metal,$peso,$pureza,$kilometraje,$descripcion,$evaluo,$valor_prestamo,$precio_venta,$imagen,1);
        return $this->conexion->setData($sql,$arrData);
    }

	//metodo insertar regiustro
    public function agregarArticulo($idcategoria,$tipo_articulo,$codigo,$nombre,$marca,$modelo,$stock,$metal,$peso,$pureza,$kilometraje,$descripcion,$evaluo,$valor_prestamo,$precio_venta,$imagen){
        $sql="INSERT INTO $this->tableName (idcategoria,tipo_articulo,codigo,nombre,marca,modelo,stock,metal,peso,pureza,kilometraje,descripcion,evaluo,valor_prestamo,precio_venta,imagen,es_garantia,condicion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idcategoria,$tipo_articulo,$codigo,$nombre,$marca,$modelo,$stock,$metal,$peso,$pureza,$kilometraje,$descripcion,$evaluo,$valor_prestamo,$precio_venta,$imagen,1,1);
        //return $this->conexion->setData($sql,$arrData);
		return    $idventanew= $this->conexion-> getReturnId($sql,$arrData);
    }

    public function editar($idcategoria,$codigo,$nombre,$descripcion,$imagen,$idarticulo){
        $sql="UPDATE $this->tableName SET idcategoria=?, codigo=?, nombre=?, descripcion=?, imagen=? WHERE idarticulo=?";
        $arrData = array($idcategoria,$codigo,$nombre,$descripcion,$imagen,$idarticulo);
        return $this->conexion->setData($sql,$arrData);
    }

	public function desactivar($idarticulo){
		$sql="UPDATE $this->tableName SET condicion='0' WHERE idarticulo=?";
		$arrData = array($idarticulo);
		return $this->conexion->setData($sql,$arrData);
	}
    
	public function activar($idarticulo){
		$sql="UPDATE $this->tableName SET condicion='1' WHERE idarticulo=?";
		$arrData = array($idarticulo);
		return $this->conexion->setData($sql,$arrData);
	}

	public function devolver($idarticulo){
		$sql="UPDATE $this->tableName SET es_garantia='0' WHERE idarticulo=?";
		$arrData = array($idarticulo);
		return $this->conexion->setData($sql,$arrData);
	}

	public function agregarPrecioVenta($idarticulo,$precio_venta){
		$sql="UPDATE $this->tableName SET precio_venta='$precio_venta', en_venta='1' WHERE idarticulo=?";
		$arrData = array($idarticulo);
		return $this->conexion->setData($sql,$arrData);
	}

	//metodo para mostrar registros
	public function mostrar(string $idarticulo){
		$sql="SELECT * FROM $this->tableName WHERE idarticulo=?";
		$arrData = array($idarticulo);
		return  $this->conexion->getData($sql,$arrData); 
	}

	public function verificarCodigo(string $codigo){
		$sql="SELECT * FROM $this->tableName WHERE codigo=?";
		$arrData = array($codigo);
		return  $this->conexion->getData($sql,$arrData);  
	}

	//listar registros
	public function listar(){
		$sql="SELECT a.*,c.nombre as categoria  FROM $this->tableName a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.es_garantia=0 AND a.en_venta=0";
		return  $this->conexion->getDataAll($sql); 
	}

	public function listarParaVenta(){
		$sql="SELECT a.*,c.nombre as categoria  FROM $this->tableName a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.es_garantia=0 AND a.en_venta=1";
		return  $this->conexion->getDataAll($sql); 
	}

	public function listarGarantia(){
		$sql="SELECT dv.idventa, a.*,c.nombre AS categoria FROM detalle_venta dv INNER JOIN $this->tableName a ON dv.idarticulo=a.idarticulo INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.es_garantia=1";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros activos
	public function listarActivos(){
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM $this->tableName a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return  $this->conexion->getDataAll($sql);
	}

	//listar y mostrar en selct
	public function listarActivosVenta(){
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo  ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,(SELECT precio_compra FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso ASC LIMIT 0,1) AS precio_compra, (SELECT idingreso FROM detalle_ingreso WHERE idarticulo=a.idarticulo LIMIT 0,1) AS idingreso ,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'AND a.stock > 0"; 
		return  $this->conexion->getDataAll($sql);
	}

	/*public function listarActivosVenta(){
		$sql="SELECT m.idingreso,m.fecha_hora,a.idarticulo,a.codigo,a.nombre,a.stock,m.cantidad,m.precio_venta, m.precio_compra,a.descripcion,a.imagen,a.condicion FROM ( SELECT di.idarticulo, di.cantidad, di.precio_compra,di.precio_venta,i.idingreso,i.fecha_hora, di.stock_estado FROM ingreso i INNER JOIN detalle_ingreso di ON i.idingreso=di.idingreso) AS m INNER JOIN articulo a ON m.idarticulo = a.idarticulo WHERE a.stock>0 AND a.condicion='1' AND m.stock_estado='1' ORDER BY m.fecha_hora ASC LIMIT 0,1";
		return  $this->conexion->getDataAll($sql);
	}*/

	public function cantidadarticulos(){
		$sql="SELECT COUNT(*) totalar FROM $this->tableName WHERE condicion=? AND stock>?";
			$arrData = array(1,0);
			return  $this->conexion->getData($sql,$arrData); 
	}
    //listar y mostrar en selct
    public function select(){
        $sql="SELECT * FROM $this->tableName WHERE condicion=1";
        return  $this->conexion->getDataAll($sql); 
    }

}

