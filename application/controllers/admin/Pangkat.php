<?php
class Pangkat extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_pangkat');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_pangkat->get_all_pangkat();
		$this->load->view('admin/v_pangkat',$x);
	}

	function simpan_pangkat(){
		$pangkat=strip_tags($this->input->post('xpangkat'));
		$this->m_pangkat->simpan_pangkat($pangkat);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/pangkat');
	}

	function update_pangkat(){
		$kode=strip_tags($this->input->post('kode'));
		$pangkat=strip_tags($this->input->post('xpangkat'));
		$this->m_pangkat->update_pangkat($kode,$pangkat);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/pangkat');
	}
	function hapus_pangkat(){
		$kode=strip_tags($this->input->post('kode'));
		$this->m_pangkat->hapus_pangkat($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/pangkat');
	}
	

}