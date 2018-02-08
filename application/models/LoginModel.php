<?php
/**
 * Created by PhpStorm.
 * User: doxa
 * Date: 31/01/18
 * Time: 08.58
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_user() {
        $query = $this->db->join('jabatan', 'jabatan.id_jabatan = pegawai.id_jabatan')
            ->where('nik', $this->input->post('nik'))
            ->where('password', md5($this->input->post('password')))
            ->get('pegawai');

        if ($query->num_rows() > 0) {
            $data_pegawai = $query->row();
            $session = array(
                'logged_in' => true,
                'nik' => $data_pegawai->nik,
                'id_pegawai' => $data_pegawai->id_pegawai,
                'id_jabatan' => $data_pegawai->id_jabatan,
                'nama_pegawai' => $data_pegawai->nama_pegawai,
                'nama_jabatan' => $data_pegawai->nama_jabatan,
                'level' => $data_pegawai->level
            );

            $this->session->set_userdata($session);
            return true;
        } else {
            return false;
        }
    }

}