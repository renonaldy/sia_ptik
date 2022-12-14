<?php
class Kategori_akademik extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_kategori_akademik');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_kategori_akademik->get_all_kategori_akademik();
		$this->load->view('admin/v_kategori_akademik',$x);
	}

	function simpan_kategori_akademik(){
		$kategori=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_akademik->simpan_kategori_akademik($kategori);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/kategori_akademik');
	}

	function update_kategori_akademik(){
		$kode=strip_tags($this->input->post('kode'));
		$kategori_akademik=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_akademik->update_kategori_akademik($kode,$kategori_akademik);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/kategori_akademik');
	}
	function hapus_kategori_akademik(){
		$kode=strip_tags($this->input->post('kode'));
		$this->m_kategori_akademik->hapus_kategori_akademik($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/kategori_akademik');
	}
	

}