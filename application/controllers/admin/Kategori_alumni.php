<?php
class Kategori_alumni extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_kategori_alumni');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_kategori_alumni->get_all_kategori_alumni();
		$this->load->view('admin/v_kategori_alumni',$x);
	}

	function simpan_kategori_alumni(){
		$kategori=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_alumni->simpan_kategori_alumni($kategori);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/kategori_alumni');
	}

	function update_kategori_alumni(){
		$kode=strip_tags($this->input->post('kode'));
		$kategori_alumni=strip_tags($this->input->post('xkategori'));
		$this->m_kategori_alumni->update_kategori_alumni($kode,$kategori_alumni);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/kategori_alumni');
	}
	function hapus_kategori_alumni(){
		$kode=strip_tags($this->input->post('kode'));
		$this->m_kategori_alumni->hapus_kategori_alumni($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/kategori_alumni');
	}
	

}