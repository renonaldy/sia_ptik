<?php
class administrasi extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_administrasi');
		$this->load->model('m_kategori_administrasi');
		$this->load->model('m_tulisan_administrasi');
		$this->load->model('m_pengguna_administrasi');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_administrasi->get_all_administrasi();
		$this->load->view('admin/v_administrasi',$x);
	}

	function administrasiUser(){
		$x['data']=$this->m_administrasi->get_all_administrasi_kirim();
		$this->load->view('admin/v_administrasiUser',$x);
	}
	function add_administrasi(){
		$x['kat']=$this->m_kategori_administrasi->get_all_kategori_administrasi();
		$this->load->view('admin/v_add_administrasi',$x);
	}
	function get_edit(){
		$kode=$this->uri->segment(4);
		$x['data']=$this->m_administrasi->get_administrasi_by_kode($kode);
		$x['kat']=$this->m_kategori_administrasi->get_all_kategori_administrasi();
		$this->load->view('admin/v_edit_administrasi',$x);
	}
	function simpan_administrasi(){
				$config['upload_path'] = './assets/administrasi/'; //path folder
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
							$kategori_administrasi_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_administrasi->get_kategori_administrasi_byid($kategori_administrasi_id);
							$q=$data->row_array();
							$kategori_administrasi_nama=$q['kategori_administrasi_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_administrasi->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_administrasi->simpan_tulisan_administrasi($judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$gambar,$slug);
							echo $this->session->set_flashdata('msg','success');
							redirect('admin/administrasi');
					}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/administrasi');
	                }
	                 
	            }else{
					redirect('admin/administrasi');
				}
				
	}
	
	function update_administrasi(){
				
	            $config['upload_path'] = './assets/administrasi/'; //path folder
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
	                        $config['source_image']='./assets/administrasi/'.$gbr['file_name'];
	                        $config['create_thumb']= FALSE;
	                        $config['maintain_ratio']= FALSE;
	                        $config['quality']= '100%';
	                        $config['width']= 840;
	                        $config['height']= 450;
	                        $config['new_image']= './assets/administrasi/'.$gbr['file_name'];
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
							$kategori_administrasi_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_administrasi->get_kategori_administrasi_byid($kategori_administrasi_id);
							$q=$data->row_array();
							$kategori_administrasi_nama=$q['kategori_administrasi_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_administrasi->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_administrasi->update_tulisan_administrasi($tulisan_id,$judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$gambar,$slug);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/administrasi');
	                    
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
							$kategori_administrasi_id=strip_tags($this->input->post('xkategori'));
							$data=$this->m_kategori_administrasi->get_kategori_administrasi_byid($kategori_administrasi_id);
							$q=$data->row_array();
							$kategori_administrasi_nama=$q['kategori_administrasi_nama'];
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_administrasi->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_tulisan_administrasi->update_tulisan_administrasi_tanpa_img($tulisan_id,$judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$slug);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/administrasi');
	            } 

	}


	function update_status(){
		$kode=$this->input->post('kode');
		$status=$this->input->post('xstatus');
		$this->db->query("UPDATE  tbl_administrasi  SET tulisan_status='$status' where administrasi_id='$kode'");
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/administrasi');
	}
	function hapus_tulisan(){
		$kode=$this->input->post('kode');
		$gambar=$this->input->post('gambar');
		$path='./assets/images/'.$gambar;
		unlink($path);
		$this->m_tulisan->hapus_tulisan($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/tulisan');
	}

}