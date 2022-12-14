<?php
class penelitian extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_penelitian');
		$this->load->model('m_kategori_penelitian');
		$this->load->model('m_tulisan_penelitian');
		$this->load->model('m_pengguna_penelitian');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_penelitian->get_all_penelitian();
		$this->load->view('admin/v_penelitian',$x);
	}

	function penelitianUser(){
		$x['data']=$this->m_penelitian->get_all_penelitian_kirim();
		$this->load->view('admin/v_penelitianUser',$x);
	}
	function add_penelitian(){
		$x['kat']=$this->m_kategori_penelitian->get_all_kategori_penelitian();
		$this->load->view('admin/v_add_penelitian',$x);
	}
	function get_edit(){
		$kode=$this->uri->segment(4);
		$x['data']=$this->m_penelitian->get_penelitian_by_kode($kode);
		$x['kat']=$this->m_kategori_penelitian->get_all_kategori_penelitian();
		$this->load->view('admin/v_edit_penelitian',$x);
	}
	function simpan_penelitian(){
				$config['upload_path'] = './assets/penelitian/'; //path folder
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
							$kategori_penelitian_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_penelitian->get_kategori_penelitian_byid($kategori_penelitian_id);
							$q=$data->row_array();
							$kategori_penelitian_nama=$q['kategori_penelitian_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_penelitian->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_penelitian->simpan_tulisan_penelitian($judul,$isi,$kategori_penelitian_id,$kategori_penelitian_nama,$user_id,$user_nama,$gambar,$slug);
							echo $this->session->set_flashdata('msg','success');
							redirect('admin/penelitian');
					}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/penelitian');
	                }
	                 
	            }else{
					redirect('admin/penelitian');
				}
				
	}
	
	function update_penelitian(){
				
	            $config['upload_path'] = './assets/penelitian/'; //path folder
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
	                        $config['source_image']='./assets/penelitian/'.$gbr['file_name'];
	                        $config['create_thumb']= FALSE;
	                        $config['maintain_ratio']= FALSE;
	                        $config['quality']= '100%';
	                        $config['width']= 840;
	                        $config['height']= 450;
	                        $config['new_image']= './assets/penelitian/'.$gbr['file_name'];
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
							$kategori_penelitian_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_penelitian->get_kategori_penelitian_byid($kategori_penelitian_id);
							$q=$data->row_array();
							$kategori_penelitian_nama=$q['kategori_penelitian_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_penelitian->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_penelitian->update_tulisan_penelitian($tulisan_id,$judul,$isi,$kategori_penelitian_id,$kategori_penelitian_nama,$user_id,$user_nama,$gambar,$slug);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/penelitian');
	                    
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
							$kategori_penelitian_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_penelitian->get_kategori_penelitian_byid($kategori_penelitian_id);
							$q=$data->row_array();
							$kategori_penelitian_nama=$q['kategori_penelitian_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_penelitian->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_penelitian->update_tulisan_penelitian_tanpa_img($tulisan_id,$judul,$isi,$kategori_penelitian_id,$kategori_penelitian_nama,$user_id,$user_nama,$slug,$gambar);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/penelitian');
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
		$path='./assets/images/'.$gambar;
		unlink($path);
		$this->m_tulisan_penelitian->hapus_tulisan_penelitian($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/tulisan');
	}

}