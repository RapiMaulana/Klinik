<?php
class klinik
{
    public $id;
    public $nama_obat;
    public $kegunaan;
     public $harga_obat;

    private $conn;
    private $table = "tbl_obat";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function add()
    {
        $query = "INSERT INTO
                " . $this->table . "
            SET
               id=:id, nama_obat=:nama_obat, kegunaan=:kegunaan, harga_obat=:harga_obat";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('nama_obat', $this->nama_obat);
        $stmt->bindParam('kegunaan', $this->kegunaan);
        $stmt->bindParam('harga_obat', $this->harga_obat);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetch()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function get()
    {
        $query = "SELECT * FROM " . $this->table . " p          
                WHERE
                    p.id = ?
                LIMIT
                0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $klinik = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $klinik['id'];
        $this->nama_obat = $klinik['nama_obat'];
        $this->kegunaan = $klinik['kegunaan'];
        $this->harga_obat = $klinik['harga_obat'];
    }

    function update()
    {
     $query = "UPDATE
                " . $this->table . "
            SET
                nama_obat = :nama_obat,
                kegunaan = :kegunaan,
                harga_obat = :harga_obat
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('nama_obat', $this->nama_obat);
        $stmt->bindParam('kegunaan', $this->kegunaan);
        $stmt->bindParam('harga_obat', $this->harga_obat);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}