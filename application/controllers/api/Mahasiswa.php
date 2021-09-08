<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/format.php';


// use namespace
use Restserver\Libraries\REST_Controller;

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        //untuk menjalankan model 
        //mahasiswa adalah nama aliyas dari sebuah model
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
    }

    //requets methos nya
    public function index_get()
    {
        //Cek di request methos get ada id nya atau tidak
        $id = $this->get('id');
        //jika id nya tidak ada
        if ($id === null) {
            //maka tampilkan semua data
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        } else {
            //jika id nya ada
            $mahasiswa = $this->mahasiswa->getwhereMahasiswa($id);
        }
        //$mahasiswa untuk menampilkan database berupa restfull api (hanya satu fungtion saja)
        //response
        if ($mahasiswa) {
            $this->response([
                'status' => TRUE,
                'data' => $mahasiswa,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'id not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        //jika id nya tidak di masukan
        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'Anda tidak memasukan id !'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            //JIKA ID NYA Ada
            //mahasiswa adalah nama model 
            if ($this->mahasiswa->deletemahasiswa($id) > 0) {
                //ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id,
                    'message' => 'Delete success'
                ], REST_Controller::HTTP_OK);
            } else {
                //jika tidak ada maka id tidak di temukan
                $this->response([
                    'status' => FALSE,
                    'message' => 'id salah !'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'nrp' => $this->input->post('nrp'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'jurusan' => $this->input->post('jurusan')
        ];

        //jika berhasil di tambahkan

        if ($this->mahasiswa->createmahasiswa($data)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data Berhasil di tambahkan!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data gagal di tambahkan !'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        //method put berfungsi untuk mengupate data di restfull api

        $id = $this->put('id');

        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        //jika berhasil di tambahkan

        if ($this->mahasiswa->updatemahasiswa($data, $id) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data Berhasil di Update!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data gagal di UPDATE !'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
