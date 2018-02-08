<?php
/**
 * Created by PhpStorm.
 * User: doxa
 * Date: 01/02/18
 * Time: 06.48
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeModel extends CI_Model {

    public function get_jumlah_surat() {
        $surat_masuk = $this->db->select('count(*) as total_surat_masuk')
            ->get('surat_masuk')->row();

        $surat_keluar = $this->db->select('count(*) as total_surat_keluar')
            ->get('surat_keluar')->row();

        return array(
            'surat_masuk' => $surat_masuk->total_surat_masuk,
            'surat_keluar' => $surat_keluar->total_surat_keluar
        );
    }

    public function get_jumlah_disposisi() {
        $disposisi_keluar = $this->db
            ->select('count(id_pegawai_pengirim) as total_disposisi_keluar')
            ->where('id_pegawai_pengirim', $this->session->userdata('id_pegawai'))
            ->get('disposisi')->row();

        $disposisi_masuk = $this->db
            ->select('count(id_pegawai_penerima) as total_disposisi_masuk')
            ->where('id_pegawai_penerima', $this->session->userdata('id_pegawai'))
            ->get('disposisi')->row();

        return array(
            'disposisi_keluar' => $disposisi_keluar->total_disposisi_keluar,
            'disposisi_masuk' => $disposisi_masuk->total_disposisi_masuk
        );
    }

    public function tambah_surat_keluar($file_surat) {
        $data = array(
            'nomor_surat' => $this->input->post('nomor_surat'),
            'tgl_kirim' => $this->input->post('tgl_kirim'),
            'tujuan' => $this->input->post('tujuan'),
            'perihal' => $this->input->post('perihal'),
            'file_surat' => $file_surat['file_name']
        );

        $this->db->insert('surat_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function tambah_surat_masuk($file_surat) {
        $data = array(
            'nomor_surat' => $this->input->post('nomor_surat'),
            'tgl_kirim' => $this->input->post('tgl_kirim'),
            'tgl_terima' => $this->input->post('tgl_terima'),
            'pengirim' => $this->input->post('pengirim'),
            'penerima' => $this->input->post('penerima'),
            'perihal' => $this->input->post('perihal'),
            'file_surat' => $file_surat['file_name']
        );

        $this->db->insert('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function tambah_disposisi($id_surat) {
        $data = array(
            'id_surat' => $id_surat,
            'id_pegawai_pengirim' => $this->session->userdata('id_jabatan'),
            'id_pegawai_penerima' => $this->input->post('tujuan_pegawai'),
            'keterangan' => $this->input->post('keterangan')
        );

        $this->db->insert('disposisi', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function disposisi_selesai($id_surat) {
        $data['status'] = 'selesai';

        $this->db->where('id_surat', $id_surat)
            ->update('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_surat_keluar() {
        $data = array(
            'nomor_surat' => $this->input->post('ubah_nomor_surat'),
            'tgl_kirim' => $this->input->post('ubah_tgl_kirim'),
            'tujuan' => $this->input->post('ubah_tujuan'),
            'perihal' => $this->input->post('ubah_perihal'),
        );

        $this->db->where('id_surat', $this->input->post('ubah_id_surat'))
            ->update('surat_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_surat_masuk() {
        $data = array(
            'nomor_surat' => $this->input->post('ubah_nomor_surat'),
            'tgl_kirim' => $this->input->post('ubah_tgl_kirim'),
            'tgl_terima' => $this->input->post('ubah_tgl_terima'),
            'pengirim' => $this->input->post('ubah_pengirim'),
            'penerima' => $this->input->post('ubah_penerima'),
            'perihal' => $this->input->post('ubah_perihal')
        );

        $this->db->where('id_surat', $this->input->post('ubah_id_surat'))
            ->update('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_file_surat_keluar($file_surat) {
        $data = array(
            'file_surat' => $file_surat['file_name']
        );

        $this->db->where('id_surat', $this->input->post('ubah_file_surat'))
            ->update('surat_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_file_surat_masuk($file_surat) {
        $data = array(
            'file_surat' => $file_surat['file_name']
        );

        $this->db->where('id_surat', $this->input->post('ubah_file_surat'))
            ->update('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_disposisi($id_surat) {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('jabatan', 'disposisi.id_pegawai_pengirim = jabatan.id_jabatan')
            ->join('pegawai', 'disposisi.id_pegawai_penerima = pegawai.id_pegawai')
            ->where('disposisi.id_surat', $id_surat)
            ->get('surat_masuk')->result();
    }

    public function get_disposisi_masuk($id_pegawai) {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('pegawai', 'disposisi.id_pegawai_pengirim = pegawai.id_pegawai')
            ->join('jabatan', 'jabatan.id_jabatan = pegawai.id_jabatan')
            ->where('id_pegawai_penerima', $id_pegawai)
            ->get('surat_masuk')->result();
    }

    public function get_disposisi_keluar($id_surat) {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('pegawai', 'disposisi.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('jabatan', 'jabatan.id_jabatan = pegawai.id_jabatan')
            ->where('disposisi.id_pegawai_pengirim', $this->session->userdata('id_jabatan'))
            ->where('disposisi.id_surat', $id_surat)
            ->get('surat_masuk')->result();
    }

    public function get_all_disposisi_keluar() {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('pegawai', 'disposisi.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('jabatan', 'jabatan.id_jabatan = pegawai.id_jabatan')
            ->where('disposisi.id_pegawai_pengirim', $this->session->userdata('id_jabatan'))
            ->get('surat_masuk')->result();
    }

    public function get_surat_keluar() {
        return $this->db->get('surat_keluar')->result();
    }

    public function get_surat_masuk() {
        return $this->db->get('surat_masuk')->result();
    }

    public function get_surat_keluar_by_id($id_surat) {
        return $this->db->where('id_surat', $id_surat)->get('surat_keluar')
            ->row();
    }

    public function get_surat_masuk_by_id($id_surat) {
        return $this->db->where('id_surat', $id_surat)->get('surat_masuk')
            ->row();
    }

    public function get_nama_file_surat_keluar($id_surat) {
        return $this->db->where('id_surat', $id_surat)
            ->get('surat_keluar')->row()->file_surat;
    }

    public function get_nama_file_surat_masuk($id_surat) {
        return $this->db->where('id_surat', $id_surat)
            ->get('surat_masuk')->row()->file_surat;
    }

    public function get_jabatan() {
        return $this->db->get('jabatan')->result();
    }

    public function get_pegawai_by_jabatan($id_jabatan) {
        return $this->db->where('id_jabatan', $id_jabatan)
            ->get('pegawai')->result();
    }

    public function cek_status_surat_masuk($id_surat) {
        $query = $this->db->where('id_surat', $id_surat)
            ->get('surat_masuk')->row()->status;

        if ($query == 'proses') {
            return true;
        } else {
            return false;
        }
    }

    public function hapus_surat_keluar($id_surat) {
        $this->db->where('id_surat', $id_surat)
            ->delete('surat_keluar');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hapus_surat_masuk($id_surat) {
        $this->db->where('id_surat', $id_surat)
            ->delete('surat_masuk');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hapus_disposisi($id_disposisi) {
        $this->db->where('id_disposisi', $id_disposisi)
            ->delete('disposisi');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}