<?php

class  Mahasiswa_model extends CI_Model
{
    public function getMahasiswa($id = null)
    {

        return $this->db->get('tabel_mahasiswa')->result();
    }
    public function getwhereMahasiswa($id)
    {
        //Menampilkan pencarian key berdasarkan id
        return $this->db->get_where('tabel_mahasiswa', ['id' => $id])->result();
    }
    public function deletemahasiswa($id)
    {
        //menghapus data berdasarkan id
        $this->db->delete('tabel_mahasiswa', ['id' => $id]);
        return  $this->db->affected_rows();
    }
    public function createmahasiswa($data)
    {
        //menghapus data berdasarkan id
        $this->db->insert('tabel_mahasiswa', $data);
        return  $this->db->affected_rows();
    }
    public function updatemahasiswa($data, $id)
    {
        $this->db->update('tabel_mahasiswa', $data, ['id' => $id]);
        return  $this->db->affected_rows();
    }
}
