<?php
class Kategori_administrasi extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_kategori_administrasi');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_kategori_administrasi->get_all_kategori_administrasi();
		$this->load->view('admin/v_kategori_administrasi',$x);
	}

	function simpan_kategori_administrasi(){
		$kategori=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_administrasi->simpan_kategori_administrasi($kategori);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/kategori_administrasi');
	}

	function update_kategori(){
		$kode=strip_tags($this->input->post('kode'));
		$kategori_administrasi=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_administrasi->update_kategori_administrasi($kode,$kategori_administrasi);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/kategori_administrasi');
	}
	function hapus_kategori(){
		$kode=strip_tags($this->input->post('kode'));
		$this->m_kategori_administrasi->hapus_kategori_administrasi($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/kategori_administrasi');
	}
	

}