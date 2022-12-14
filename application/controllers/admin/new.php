<?php
class dosen extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_dosen');
		$this->load->model('m_pengguna');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_dosen->get_all_dosen();
		$this->load->view('admin/v_dosen',$x);
	}

	function dosenUser(){
		$x['data']=$this->m_dosen->get_all_dosen_kirim();
		$this->load->view('admin/v_dosenUser',$x);
	}

	function add_dosen(){
		$this->load->view('admin/v_add_dosen');
	}
	function get_edit(){
		$kode=$this->uri->segment(4);
		$x['data']=$this->m_dosen->get_dosen_by_kode($kode);
		$this->load->view('admin/v_edit_dosen',$x);
	}
	function simpan_dosen(){
				$config['upload_path'] = './assets/dosen/'; //path folder
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
							$nama_dosen=strip_tags($this->input->post('nama_dosen'));
							$nidn=strip_tags($this->input->post('nidn'));
							$nik=strip_tags($this->input->post('nik'));
							$jenis_kelamin=strip_tags($this->input->post('jenis_kelamin'));
							$jabatan=strip_tags($this->input->post('jabatan'));
							$pangkat=strip_tags($this->input->post('pangkat'));
							$no_sertifikasi=strip_tags($this->input->post('no_sertifikasi'));
							$photo=strip_tags($this->input->post('photo'));
							$pra_slug=$filter2.'.html';
							$slug=strtolower(str_replace(" ", "-", $pra_slug));
							$data=$this->m_dosen->get_dosen_byid();
							$q=$data->row_array();
							$kode=$this->session->userdata('idadmin');
							$user=$this->m_pengguna_administrasi->get_pengguna_login($kode);
							$p=$user->row_array();
							$user_id=$p['pengguna_id'];
							$user_nama=$p['pengguna_nama'];
							$this->m_dosen->simpan_dosen($q,$nama_dosen,$nidn,$nik,$jenis_kelamin,$jabatan,$pangkat,$no_sertifikasi,$user_id,$user_nama,$gambar,$photo,$slug);
							echo $this->session->set_flashdata('msg','success');
							redirect('admin/dosen');
					}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/dosen');
	                }
	                 
	            }else{
					redirect('admin/dosen');
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
							$this->m_tulisan_administrasi->update_tulisan_tanpa_img($tulisan_id,$judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$slug);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/administrasi');
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
		$this->m_tulisan->hapus_tulisan($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/tulisan');
	}

}