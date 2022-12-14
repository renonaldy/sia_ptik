<?php
class Akademik extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_akademik');
		$this->load->model('m_kategori_akademik');
		$this->load->model('m_tulisan_akademik');
		$this->load->model('m_pengguna_akademik');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_akademik->get_all_akademik();
		$this->load->view('admin/v_akademik',$x);
	}

	function akademikUser(){
		$x['data']=$this->m_akademik->get_all_akademik_kirim();
		$this->load->view('admin/v_akademikUser',$x);
	}
	function add_akademik(){
		$x['kat']=$this->m_kategori_akademik->get_all_kategori_akademik();
		$this->load->view('admin/v_add_akademik',$x);
	}
	function get_edit(){
		$kode=$this->uri->segment(4);
		$x['data']=$this->m_akademik->get_akademik_by_kode($kode);
		$x['kat']=$this->m_kategori_akademik->get_all_kategori_akademik();
		$this->load->view('admin/v_edit_akademik',$x);
	}
	function simpan_akademik(){
				$config['upload_path'] = './assets/akademik/'; //path folder
	            $config['allowed_types'] = 'pdf|jpg|png'; //type file yang dapat diakses
	            $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

	            $this->upload->initialize($config);
	            if(!empty($_FILES['filefoto']['name']))
	            {
	                if ($this->upload->do_upload('filefoto'))
	                {
	                        $gbr = $this->upload->data();
	                        //Compress Image
	                        $config['image_library']='gd2';
	                        $config['source_image']='./assets/images/'.$gbr['file_name'];
	                        $config['create_thumb']= FALSE;
	                        $config['maintain_ratio']= FALSE;
	                        $config['quality']= '60%';
	                        $config['width']= 840;
	                        $config['height']= 450;
	                        $config['new_image']= './assets/images/'.$gbr['file_name'];
	                        $this->load->library('image_lib', $config);
	                        $this->image_lib->resize();

	                        $gambar=$gbr['file_name'];
							$judul=strip_tags($this->input->post('xjudul'));
							$filter=str_replace("?", "", $judul);
							$filter2=str_replace("$", "", $filter);
							$pra_slug=$filter2.'.html';
							$slug=strtolower(str_replace(" ", "-", $pra_slug));
							$isi=$this->input->post('xisi');
							$kategori_akademik_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_akademik->get_kategori_akademik_byid($kategori_akademik_id);
							$q=$data->row_array();
							$kategori_akademik_nama=$q['kategori_akademik_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_akademik->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_akademik->simpan_tulisan_akademik($judul,$isi,$kategori_akademik_id,$kategori_akademik_nama,$user_id,$user_nama,$gambar,$slug);
							echo $this->session->set_flashdata('msg','success');
							redirect('admin/akademik');
					}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/akademik');
	                }
	                 
	            }else{
					redirect('admin/akademik');
				}
				
	}
	
	function update_akademik(){
				
	            $config['upload_path'] = './assets/akademik/'; //path folder
	            $config['allowed_types'] = 'pdf|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
	            $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

	            $this->upload->initialize($config);
	            if(!empty($_FILES['filefoto']['name']))
	            {
	                if ($this->upload->do_upload('filefoto'))
	                {
	                        $gbr = $this->upload->data();
	                        //Compress Image
	                        $config['image_library']='gd2';
	                        $config['source_image']='./assets/akademik/'.$gbr['file_name'];
	                        $config['create_thumb']= FALSE;
	                        $config['maintain_ratio']= FALSE;
	                        $config['quality']= '100%';
	                        $config['width']= 840;
	                        $config['height']= 450;
	                        $config['new_image']= './assets/akademik/'.$gbr['file_name'];
	                        $this->load->library('image_lib', $config);
	                        $this->image_lib->resize();

	                        $gambar=$gbr['file_name'];
	                        $tulisan_id=$this->input->post('kode');
	                        $judul=strip_tags($this->input->post('xjudul'));
	                        $filter=str_replace("?", "", $judul);
							$filter2=str_replace("$", "", $filter);
							$pra_slug=$filter2.'.html';
							$slug=strtolower(str_replace(" ", "-", $pra_slug));
							$isi=$this->input->post('xisi');
							$kategori_akademik_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_akademik->get_kategori_akademik_byid($kategori_akademik_id);
							$q=$data->row_array();
							$kategori_akademik_nama=$q['kategori_akademik_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_akademik->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_akademik->update_tulisan_akademik($tulisan_id,$judul,$isi,$kategori_akademik_id,$kategori_akademik_nama,$user_id,$user_nama,$gambar,$slug);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/akademik');
	                    
	                }else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pengguna');
	                }
	                
	            }else{
							$tulisan_id=$this->input->post('kode');
							$judul=strip_tags($this->input->post('xjudul'));
							$filter=str_replace("?", "", $judul);
							$filter2=str_replace("$", "", $filter);
							$pra_slug=$filter2.'.html';
							$slug=strtolower(str_replace(" ", "-", $pra_slug));
							$isi=$this->input->post('xisi');
							$kategori_akademik_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_akademik->get_kategori_akademik_byid($kategori_akademik_id);
							$q=$data->row_array();
							$kategori_akademik_nama=$q['kategori_akademik_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_akademik->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_akademik->update_tulisan_akademik_tanpa_img($tulisan_id,$judul,$isi,$kategori_akademik_id,$kategori_akademik_nama,$user_id,$user_nama,$slug);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/akademik');
	            } 

	}


	function update_status(){
		$kode=$this->input->post('kode');
		$status=$this->input->post('xstatus');
		$this->db->query("UPDATE  tbl_tulisan  SET tulisan_status='$status' where tulisan_id='$kode'");
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/tulisan');
	}
	function hapus_tulisan(){
		$kode=$this->input->post('kode');
		$gambar=$this->input->post('gambar');
		$path='./assets/images/akademik'.$gambar;
		unlink($path);
		$this->m_tulisan_akademik->hapus_tulisan_akademik($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/akademik');
	}

}