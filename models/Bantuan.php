<?php
class Bantuan {
    private $conn;
    private $table_masuk = "tbantuanmasuk";
    private $table_salur = "tbantuansalur";

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- BAGIAN 1: BANTUAN MASUK ---
    public function getSemuaBantuanMasuk() {
        $query = "SELECT * FROM " . $this->table_masuk . " ORDER BY tanggalmasuk ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function tambahBantuan($data) {
        $query = "INSERT INTO " . $this->table_masuk . " 
                  (id, donatur, isibantuan, tanggalmasuk, nilai, daerahsalur, status) 
                  VALUES (:id, :donatur, :isibantuan, :tanggalmasuk, :nilai, :daerahsalur, 'masuk')";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitasi sederhana
        $id = htmlspecialchars(strip_tags($data['id']));
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":donatur", $data['donatur']);
        $stmt->bindParam(":isibantuan", $data['isibantuan']);
        $stmt->bindParam(":tanggalmasuk", $data['tanggalmasuk']);
        $stmt->bindParam(":nilai", $data['nilai']);
        $stmt->bindParam(":daerahsalur", $data['daerahsalur']);

        return $stmt->execute();
    }

    public function updateBantuan($id, $nilai, $status) {
        $query = "UPDATE " . $this->table_masuk . " SET nilai = :nilai, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nilai", $nilai);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function hapusBantuan($id) {
        $query = "DELETE FROM " . $this->table_masuk . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function salurkanBantuan($id, $statusAkhir) {
        try {
            $this->conn->beginTransaction();

            $queryGet = "SELECT * FROM " . $this->table_masuk . " WHERE id = :id";
            $stmtGet = $this->conn->prepare($queryGet);
            $stmtGet->bindParam(':id', $id);
            $stmtGet->execute();
            $data = $stmtGet->fetch(PDO::FETCH_ASSOC);

            if (!$data) throw new Exception("Data tidak ditemukan");

            $queryInsert = "INSERT INTO " . $this->table_salur . " 
                            (id, donatur, isibantuan, tanggalmasuk, nilai, daerahsalur, status) 
                            VALUES (:id, :donatur, :isibantuan, :tanggalmasuk, :nilai, :daerahsalur, :status)";
            
            $stmtInsert = $this->conn->prepare($queryInsert);
            $stmtInsert->bindParam(":id", $data['id']);
            $stmtInsert->bindParam(":donatur", $data['donatur']);
            $stmtInsert->bindParam(":isibantuan", $data['isibantuan']);
            $stmtInsert->bindParam(":tanggalmasuk", $data['tanggalmasuk']);
            $stmtInsert->bindParam(":nilai", $data['nilai']);
            $stmtInsert->bindParam(":daerahsalur", $data['daerahsalur']);
            $stmtInsert->bindParam(":status", $statusAkhir); 
            $stmtInsert->execute();

            $this->hapusBantuan($id);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // --- BAGIAN 2: BANTUAN SALUR (BARU DITAMBAHKAN) ---
    public function getSemuaBantuanSalur() {
        $query = "SELECT * FROM " . $this->table_salur . " ORDER BY tanggalmasuk DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Update status di tabel salur (jika tombol ubah di tabel bawah diklik)
    public function updateStatusSalur($id, $status) {
        $query = "UPDATE " . $this->table_salur . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>