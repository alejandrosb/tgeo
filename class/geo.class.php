<?php
class Geo
{
    private static $instancia;
    private $dbh;

    private function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=tnote', 'root', '');
            $this->dbh->exec("SET CHARACTER SET utf8");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public static function singleton()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function get_geo()
    {
        try {
            $query = $this->dbh->prepare('select * from geo');
            $query->execute();
            return $query->fetchAll();
            $this->dbh = null;
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function delete_geo($id)
    {
        try {
            $query = $this->dbh->prepare('delete from geo where id = ?');
            $query->bindParam(1, $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function insert_usuario($descripcion,$lati,$lngi)
    {
        try {
            $query = $this->dbh->prepare('insert into geo (id,descri,lat,lng) values(null,UPPER(?),?,?)');
            $query->bindParam(1, $descripcion);
            $query->bindParam(2, $lati);
            $query->bindParam(3, $lngi);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function update_usuario($id,$nombre,$direccion,$ruc,$telefono)
    {
        try {
            $query = $this->dbh->prepare('update cliente SET nombre =UPPER(?), direccion = UPPER(?), ruc = ?, telefono = ? WHERE codcli = ?');
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $direccion);
            $query->bindParam(3, $ruc);
            $query->bindParam(4, $telefono);
            $query->bindParam(5, $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }



	public function get_busca($nom)
    {
        try {
            $query = $this->dbh->prepare('select * from cliente where nombre like ?');
            $query->bindValue(1, $nom,PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll();
            $this->dbh = null;
        }catch (PDOException $e) {
            $e->getMessage();
        }
    }



    public function __clone()
    {
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }
}
?>
