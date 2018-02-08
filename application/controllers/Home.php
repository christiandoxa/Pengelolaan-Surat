<?php
/**
 * Created by PhpStorm.
 * User: doxa
 * Date: 31/01/18
 * Time: 07.22
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  HomeModel $HomeModel
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('HomeModel');
    }

    public function index() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $data['judul'] = 'Welcome, ' . $this->session->userdata('nama_pegawai') . '!';
                $data['jumlah_surat'] = $this->HomeModel->get_jumlah_surat();
                $data['main_view'] = 'admin/dashboard';
                $this->load->view('template', $data);
            } else {
                $data['judul'] = 'Welcome, ' . $this->session->userdata('nama_pegawai') . '!';
                $data['jumlah_disposisi'] = $this->HomeModel->get_jumlah_disposisi();
                $data['main_view'] = 'pegawai/dashboard';
                $this->load->view('template', $data);
            }
        } else {
            redirect('login');
        }
    }

    public function surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $data['judul'] = 'Surat Masuk';
                $data['main_view'] = 'admin/surat_masuk';
                $data['data_surat_masuk'] = $this->HomeModel->get_surat_masuk();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $data['judul'] = 'Surat Keluar';
                $data['main_view'] = 'admin/surat_keluar';
                $data['data_surat_keluar'] = $this->HomeModel->get_surat_keluar();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function disposisi_selesai($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                if ($this->HomeModel->disposisi_selesai($id_surat) == true) {
                    $this->session->set_flashdata('notif', 'Disposisi surat ini telah selesai!');
                    redirect('home/disposisi/' . $id_surat);
                } else {
                    $this->session->set_flashdata('notif', 'Gagal update status disposisi!');
                    redirect('home/disposisi/' . $id_surat);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function disposisi($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $data['judul'] = 'Disposisi Surat';
                $data['main_view'] = 'admin/disposisi';
                $data['data_surat'] = $this->HomeModel->get_surat_masuk_by_id($id_surat);
                $data['drop_down_jabatan'] = $this->HomeModel->get_jabatan();
                $data['data_disposisi'] = $this->HomeModel->get_disposisi($id_surat);
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function disposisi_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Keluar';
            $data['main_view'] = 'pegawai/disposisi_keluar';
            $data['data_disposisi_keluar'] = $this->HomeModel->get_all_disposisi_keluar();
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function disposisi_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Masuk';
            $data['main_view'] = 'pegawai/disposisi_masuk';
            $data['data_disposisi_masuk'] = $this->HomeModel->get_disposisi_masuk($this->session->userdata('id_pegawai'));
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function disposisi_keluar_pegawai($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Keluar';
            $data['main_view'] = 'pegawai/disposisi_keluar';
            $data['data_surat'] = $this->HomeModel->get_surat_masuk_by_id($id_surat);
            $data['data_disposisi_keluar'] = $this->HomeModel->get_disposisi_keluar($id_surat);
            $data['drop_down_jabatan'] = $this->HomeModel->get_jabatan();
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function tambah_disposisi($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $this->form_validation->set_rules('tujuan_unit', 'Tujuan Unit', 'trim|required');
                $this->form_validation->set_rules('tujuan_pegawai', 'Tujuan Pegawai', 'trim|required');
                $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->HomeModel->tambah_disposisi($id_surat) == true) {
                        $this->session->set_flashdata('notif', 'Tambah disposisi surat berhasil!');
                        redirect('home/disposisi/' . $id_surat);
                    } else {
                        $this->session->set_flashdata('notif', 'Tambah disposisi surat gagal!');
                        redirect('home/disposisi/' . $id_surat);
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/disposisi/' . $id_surat);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function tambah_disposisi_pegawai($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            $this->form_validation->set_rules('tujuan_unit', 'Tujuan Unit', 'trim|required');
            $this->form_validation->set_rules('tujuan_pegawai', 'Tujuan Pegawai', 'trim|required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

            if ($this->form_validation->run() == true) {
                if ($this->HomeModel->tambah_disposisi($id_surat) == true) {
                    $this->session->set_flashdata('notif', 'Tambah disposisi surat berhasil!');
                    redirect('home/disposisi_keluar_pegawai/' . $id_surat);
                } else {
                    $this->session->set_flashdata('notif', 'Tambah disposisi surat gagal!');
                    redirect('home/disposisi_keluar_pegawai/' . $id_surat);
                }
            } else {
                $this->session->set_flashdata('notif', validation_errors());
                redirect('home/disposisi_keluar_pegawai/' . $id_surat);
            }
        } else {
            redirect('login');
        }
    }

    public function tambah_surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('tujuan', 'Tujuan', 'trim|required');
                $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 2000000;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file_surat')) {
                        if ($this->HomeModel->tambah_surat_keluar($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Tambah Surat Keluar Berhasil!');
                            redirect('home/surat_keluar');
                        } else {
                            $this->session->set_flashdata('notif', 'Tambah Surat Gagal!');
                            redirect('home/surat_keluar');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function tambah_surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('tgl_kirim', 'Tanggal Kirim', 'trim|date|required');
                $this->form_validation->set_rules('tgl_terima', 'Tanggal Terima', 'trim|date|required');
                $this->form_validation->set_rules('pengirim', 'Pengirim', 'trim|required');
                $this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
                $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 2000000;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file_surat')) {
                        if ($this->HomeModel->tambah_surat_masuk($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Tambah Surat Berhasil!');
                            redirect('home/surat_masuk');
                        } else {
                            $this->session->set_flashdata('notif', 'Tambah Surat Berhasil!');
                            redirect('home/surat_masuk');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function ubah_surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $this->form_validation->set_rules('ubah_nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('ubah_tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('ubah_tujuan', 'Tujuan', 'trim|required');
                $this->form_validation->set_rules('ubah_perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->HomeModel->ubah_surat_keluar() == true) {
                        $this->session->set_flashdata('notif', 'Ubah Surat Keluar Berhasil!');
                        redirect('home/surat_keluar');
                    } else {
                        $this->session->set_flashdata('notif', 'Ubah Surat Keluar Gagal!');
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function ubah_surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $this->form_validation->set_rules('ubah_nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('ubah_tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('ubah_tgl_terima', "Tanggal Terima", 'trim|required');
                $this->form_validation->set_rules('ubah_pengirim', 'Pengirim', 'trim|required');
                $this->form_validation->set_rules('ubah_penerima', 'Penerima', 'trim|required');
                $this->form_validation->set_rules('ubah_perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->HomeModel->ubah_surat_masuk() == true) {
                        $this->session->set_flashdata('notif', 'Update Surat Masuk Berhasil!');
                        redirect('home/surat_masuk');
                    } else {
                        $this->session->set_flashdata('notif', 'Update Surat Masuk Gagal!');
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function ubah_file_surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2000000;
                $this->load->library('upload', $config);
                $path = './uploads/' . $this->HomeModel->get_nama_file_surat_keluar($this->input->post('ubah_file_surat'));
                if (unlink($path)) {
                    if ($this->upload->do_upload('ubah_file_surat')) {
                        if ($this->HomeModel->ubah_file_surat_keluar($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Ubah file surat keluar berhasil!');
                            redirect('home/surat_keluar');
                        } else {
                            $this->session->set_flashdata('notif', 'Ubah file surat keluar gagal!');
                            redirect('home/surat_keluar');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function ubah_file_surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2000000;
                $this->load->library('upload', $config);
                $path = './uploads/' . $this->HomeModel->get_nama_file_surat_masuk($this->input->post('ubah_file_surat'));

                if (unlink($path)) {
                    if ($this->upload->do_upload('ubah_file_surat')) {
                        if ($this->HomeModel->ubah_file_surat_masuk($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Ubah file surat masuk berhasil!');
                            redirect('home/surat_masuk');
                        } else {
                            $this->session->set_flashdata('notif', 'Ubah file surat masuk gagal!');
                            redirect('home/surat_masuk');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function get_surat_keluar_by_id($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $data_surat_keluar_by_id = $this->HomeModel->get_surat_keluar_by_id($id_surat);
                echo json_encode($data_surat_keluar_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function get_surat_masuk_by_id($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $data_surat_masuk_by_id = $this->HomeModel->get_surat_masuk_by_id($id_surat);
                echo json_encode($data_surat_masuk_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function get_pegawai_by_jabatan($id_jabatan) {
        if ($this->session->userdata('logged_in') == true) {
            $data_pegawai_by_id_jabatan = $this->HomeModel->get_pegawai_by_jabatan($id_jabatan);
            echo json_encode($data_pegawai_by_id_jabatan);
        } else {
            redirect('login');
        }
    }

    public function hapus_surat_keluar($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $path = './uploads/' . $this->HomeModel->get_nama_file_surat_keluar($id_surat);

                if (unlink($path)) {
                    if ($this->HomeModel->hapus_surat_keluar($id_surat) == true) {
                        $this->session->set_flashdata('notif', 'Hapus surat keluar berhasil!');
                        redirect('home/surat_keluar');
                    } else {
                        $this->session->set_flashdata('notif', 'Hapus surat keluar gagal');
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function hapus_surat_masuk($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                $path = './uploads/' . $this->HomeModel->get_nama_file_surat_masuk($id_surat);
                if (unlink($path)) {
                    if ($this->HomeModel->hapus_surat_masuk($id_surat) == true) {
                        $this->session->set_flashdata('notif', 'Hapus Surat Berhasil!');
                        redirect('home/surat_masuk');
                    } else {
                        $this->session->set_flashdata('notif', 'Tidak dapat menghapus surat!');
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Tidak dapat menghapus berkas dokumen!');
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function hapus_disposisi($id_disposisi, $id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('nama_jabatan') == 'Sekretaris') {
                if ($this->HomeModel->hapus_disposisi($id_disposisi) == true) {
                    $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Berhasil!');
                    redirect('home/disposisi/' . $id_surat);
                } else {
                    $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Gagal!');
                    redirect('home/disposisi' . $id_surat);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }

    public function hapus_disposisi_pegawai($id_disposisi, $id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->HomeModel->hapus_disposisi($id_disposisi) == true) {
                $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Berhasil!');
                redirect('home/disposisi_keluar_pegawai/' . $id_surat);
            } else {
                $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Gagal!');
                redirect('home/disposisi_keluar_pegawai/' . $id_surat);
            }
        } else {
            redirect('login');
        }
    }

}
