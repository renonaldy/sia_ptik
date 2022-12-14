<?php
class Jabatan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_jabatan');
		$this->load->library('upload');
	}

	function index(){
		$x['data']=$this->m_jabatan->get_all_jabatan();
		$this->load->view('admin/v_jabatan',$x);
	}

	function simpan_jabatan(){
		$jabatan=strip_tags($this->input->post('xjabatan'));
		$this->m_jabatan->simpan_jabatan($jabatan);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/jabatan');
	}

	function update_jabatan(){
		$kode=strip_tags($this->input->post('kode'));
		$jabatan=strip_tags($this->input->post('xjabatan'));
		$this->m_jabatan->update_jabatan($kode,$jabatan);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/jabatan');
	}
	function hapus_jabatan(){
		$kode=strip_tags($this->input->post('kode'));
		$this->m_jabatan->hapus_jabatan($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/jabatan');
	}
	

}