<?php
/**
 * Created by PhpStorm.
 * User: doxa
 * Date: 31/01/18
 * Time: 07.50
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  LoginModel $LoginModel
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LoginModel');

    }

    public function index() {
        $this->load->view('login');
    }

    public function validate() {
        if ($this->session->userdata('logged_in') == true) {
            redirect('home');
        } else {
            $this->form_validation->set_rules('nik', 'NIK', 'trim|required|numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == true) {
                if ($this->LoginModel->check_user() == true) {
                    $this->session->set_flashdata('notif', 'Login berhasil!');
                    redirect('home');
                } else {
                    $this->session->set_flashdata('notif', 'NIK atau Password salah!');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('notif', validation_errors());
                redirect('login');
            }
        }
    }

    public function logout() {
        if ($this->session->userdata('logged_in') == true) {
            $this->session->sess_destroy();
            redirect('login');
        }
    }

}