<?php 
class prosesCrud {

    protected $db;
    function __construct($db){
        $this->db = $db;
    }

    function proses_login($user,$pass)
    {
        
        $row = $this->db->prepare('SELECT * FROM users WHERE username=? ');
        $row->execute(array($user));
        $count = $row->rowCount();
        if($count > 0)
        {
            $hasil = $row->fetch();
            if( password_verify($pass, $hasil['password']) ) {
                return $hasil;
            } else {
                return 'gagal';
            }
        }else{
            return 'gagal';
        }
    }

    

    function tampil_data($tabel)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel");
        $row->execute();
        return $hasil = $row->fetchAll();
    }

    
    
    function tampil_data_id($tabel,$where,$id)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel  WHERE $where = ?");
        $row->execute(array($id));
        return $hasil = $row->fetch();
    }

    function tambah_data($tabel,$data)
    {
        
        
        $rowsSQL = array();
        
        $toBind = array();
        
        $columnNames = array_keys($data[0]);
        
        foreach($data as $arrayIndex => $row){
            $params = array();
            foreach($row as $columnName => $columnValue){
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }
        $sql = "INSERT INTO $tabel (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
        $row = $this->db->prepare($sql);
        
        foreach($toBind as $param => $val){
            $row ->bindValue($param, $val);
        }
        
        return $row ->execute();
    }

    function edit_data($tabel,$data,$where,$id)
    {
        
        
        $setPart = array();
        foreach ($data as $key => $value)
        {
            $setPart[] = $key."=:".$key;
        }
        $sql = "UPDATE $tabel SET ".implode(', ', $setPart)." WHERE $where = :id";
        $row = $this->db->prepare($sql);
        
        $row ->bindValue(':id',$id);
        foreach($data as $param => $val)
        {
            $row ->bindValue($param, $val);
        }
        return $row ->execute();
    }

    function hapus_data($tabel,$where,$id)
    {
        $sql = "DELETE FROM $tabel WHERE $where = ?";
        $row = $this->db->prepare($sql);
        return $row ->execute(array($id));
    }


    function uploadfoto()
    {
        
        $namafile = $_FILES['asset']['name'];
        $ukuranfile = $_FILES['asset']['size'];
        $error = $_FILES['asset']['error'];
        $tmpname = $_FILES['asset']['tmp_name'];
        
        // cek sudah memilih video atau belum
        if($error === 4){
            echo '<script>alert("Pilih Foto Terlebih Dahulu") </script>';
            return false;
        }

        $extensivalid = ['jpg','png','jpeg'];
        $extensivideo = explode('.', $namafile);
        $extensivideo = strtolower(end($extensivideo));

        // cek file yang dikirim video atau bukan
        if(!in_array($extensivideo,$extensivalid)){
            echo '<script>alert("Foto Harus Berformat PNG, JPG, JPEG") </script>';
            return false;
        }
        // cek ukuran file agar tidak terlalu besar
        if($ukuranfile > 10000000) {
            echo '<script>alert("Ukuran Foto Terlalu Besar") </script>';
            return false;
        }

        // agar nama video tidak sama
        $namafilebaru = uniqid();
        $namafilebaru .= '.';
        $namafilebaru .=$extensivideo;

        // jika video siap upload
        move_uploaded_file($tmpname, 'asset/image/' . $namafilebaru);

        return $namafilebaru;
    }
    function uploadvideo()
    {
        
        $namafile = $_FILES['asset']['name'];
        $ukuranfile = $_FILES['asset']['size'];
        $error = $_FILES['asset']['error'];
        $tmpname = $_FILES['asset']['tmp_name'];
        
        // cek sudah memilih gambar atau belum
        if($error === 4){
            echo '<script>alert("Pilih Foto Terlebih Dahulu") </script>';
            return false;
        }

        $extensivalid = ['mp4','webp','avi'];
        $extensivideo = explode('.', $namafile);
        $extensivideo = strtolower(end($extensivideo));

        // cek file yang dikirim video atau bukan
        if(!in_array($extensivideo,$extensivalid)){
            echo '<script>alert("Foto Harus Berformat MP4, WEBP, AVI") </script>';
            return false;
        }
        // cek ukuran file agar tidak terlalu besar
        if($ukuranfile > 100000000) {
            echo '<script>alert("Ukuran Foto Terlalu Besar") </script>';
            return false;
        }

        // agar nama video tidak sama
        $namafilebaru = uniqid();
        $namafilebaru .= '.';
        $namafilebaru .=$extensivideo;

        // jika video siap upload
        move_uploaded_file($tmpname, 'asset/video/' . $namafilebaru);

        return $namafilebaru;
    }

    function tampil_data_foto($tabel)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE kategori='foto' ");
        $row->execute();
        return $hasil = $row->fetchAll();
    }
    function tampil_data_video($tabel)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE kategori='video' ");
        $row->execute();
        return $hasil = $row->fetchAll();
    }


}