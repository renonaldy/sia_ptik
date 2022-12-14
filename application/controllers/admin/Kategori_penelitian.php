<?php
class Kategori_penelitian extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_kategori_penelitian');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_kategori_penelitian->get_all_kategori_penelitian();
		$this->load->view('admin/v_kategori_penelitian',$x);
	}

	function simpan_kategori_penelitian(){
		$kategori=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_penelitian->simpan_kategori_penelitian($kategori);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/kategori_penelitian');
	}

	function update_kategori_penelitian(){
		$kode=strip_tags($this->input->post('kode'));
		$kategori_penelitian=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_penelitian->update_kategori_penelitian($kode,$kategori_penelitian);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/kategori_penelitian');
	}
	function hapus_kategori_penelitian(){
		$kode=strip_tags($this->input->post('kode'));
		$this->m_kategori_penelitian->hapus_kategori_penelitian($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/kategori_penelitian');
	}
	

}