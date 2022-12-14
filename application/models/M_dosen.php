<?php
class M_dosen extends CI_Model{

	function get_all_dosen(){
		$hsl=$this->db->query("SELECT tbl_dosen.* FROM tbl_dosen ORDER BY id_dosen DESC");
		return $hsl;
	}
	function get_all_dosen_kirim(){
		$hsl=$this->db->query("SELECT tbl_dosen.* FROM tbl_dosen ORDER BY id_dosen DESC");
		return $hsl;
	}

	function simpan_dosen($nama_dosen,$nidn,$nik,$jenis_kelamin,$jabatan,$pangkat,$no_sertifikasi,$photo){
		$hsl=$this->db->query("insert into tbl_dosen(nama_dosen,nidn,nik,jenis_kelamin,jabatan,pangkat,no_sertifikasi,photo) values ('$nama_dosen','$nidn','$nik','$jenis_kelamin','$jabatan','$pangkat','$no_sertifikasi','$photo')");
		return $hsl;
	}
	function get_dosen_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_dosen.* FROM tbl_dosen where id_dosen='$kode'");
		return $hsl;
	}
	function update_dosen($id_dosen,$nama_dosen,$nidn,$nik,$jabatan,$pangkat,$no_sertifikasi,$photo,$jenis_kelamin){
		$hsl=$this->db->query("update tbl_dosen set nama_dosen='$nama_dosen',nidn='$nidn',nik='$nik',jabatan='$jabatan',pangkat='$pangkat',no_sertifikasi='$no_sertifikasi',photo='$photo',jenis_kelamin='$jenis_kelamin' where id_dosen='$id_dosen'");
		return $hsl;
	}
	function update_dosen_tanpa_img($id_dosen,$nama_dosen,$nidn,$nik,$jabatan,$pangkat,$no_sertifikasi,$jenis_kelamin){
		$hsl=$this->db->query("update tbl_dosen set nama_dosen='$nama_dosen',nidn='$nidn',nik='$nik',jabatan='$jabatan',pangkat='$pangkat',no_sertifikasi='$no_sertifikasi',jenis_kelamin='$jenis_kelamin' where id_dosen='$id_dosen'");
		return $hsl;
	}
	function hapus_dosen($kode){
		$hsl=$this->db->query("delete from tbl_dosen where id_dosen='$kode'");
		return $hsl;
	}


	//Front-End

	function get_post_home(){
		$hsl=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d %M %Y') AS tanggal FROM tbl_dosen where akademik_status='1' ORDER BY id_dosen DESC limit 6");
		return $hsl;
	}

	function get_berita_slider(){
		$hsl=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_dosen where akademik_img_slider='1' ORDER BY id_dosen DESC");
		return $hsl;
	}

	function berita_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_dosen ORDER BY id_dosen DESC limit $offset,$limit");
		return $hsl;
	}

	function berita(){
		$hsl=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_dosen ORDER BY id_dosen DESC");
		return $hsl;
	} 
	function get_berita_by_jenis_kelamin($jenis_kelamin){
		$hsl=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_dosen where akademik_jenis_kelamin='$jenis_kelamin'");
		return $hsl;
	}



	function search_tulisan($keyword){
		$hsl=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_dosen WHERE akademik_nama_dosen LIKE '%$keyword%'");
		return $hsl;
	}

	function post_komentar($nama,$email,$web,$msg,$id_dosen){
		$hsl=$this->db->query("INSERT INTO tbl_komentar (komentar_nama,komentar_email,komentar_web,komentar_nidn,komentar_id_dosen) VALUES ('$nama','$email','$web','$msg','$id_dosen')");
		return $hsl;
	}


	function count_views($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_views WHERE views_ip='$user_ip' AND views_id_dosen='$kode' AND DATE(views_tanggal)=CURDATE()");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_views (views_ip,views_id_dosen) VALUES('$user_ip','$kode')");
				$this->db->query("UPDATE tbl_dosen SET akademik_views=akademik_views+1 where id_dosen='$kode'");
			$this->db->trans_complete();
			if($this->db->trans_status()==TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
        }
    }

    //Count rating Good
    function count_good($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_id_dosen='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_id_dosen) VALUES('$user_ip','1','$kode')");
				$this->db->query("UPDATE tbl_dosen SET tulisan_rating=tulisan_rating+1 where id_dosen='$kode'");
			$this->db->trans_complete();
			if($this->db->trans_status()==TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
        }
    }

    //Count rating Like
    function count_like($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_id_dosen='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_id_dosen) VALUES('$user_ip','2','$kode')");
				$this->db->query("UPDATE tbl_dosen SET tulisan_rating=tulisan_rating+2 where id_dosen='$kode'");
			$this->db->trans_complete();
			if($this->db->trans_status()==TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
        }
    }

    //Count rating Like
    function count_love($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_id_dosen='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_id_dosen) VALUES('$user_ip','3','$kode')");
				$this->db->query("UPDATE tbl_dosen SET tulisan_rating=tulisan_rating+3 where id_dosen='$kode'");
			$this->db->trans_complete();
			if($this->db->trans_status()==TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
        }
    }

    //Count rating Like
    function count_genius($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_id_dosen='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_id_dosen) VALUES('$user_ip','4','$kode')");
				$this->db->query("UPDATE tbl_dosen SET tulisan_rating=tulisan_rating+4 where id_dosen='$kode'");
			$this->db->trans_complete();
			if($this->db->trans_status()==TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
        }
    }

    function cek_ip_rate($kode){
    	$user_ip=$_SERVER['REMOTE_ADDR'];
        $hsl=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_id_dosen='$kode'");
        return $hsl;
    }


    function get_akademik_populer(){
		$hasil=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d %M %Y') AS tanggal FROM tbl_dosen ORDER BY tulisan_views DESC limit 10");
		return $hasil;
	}

	function get_akademik_terbaru(){
		$hasil=$this->db->query("SELECT tbl_dosen.*,DATE_FORMAT(akademik_tanggal,'%d %M %Y') AS tanggal FROM tbl_dosen ORDER BY id_dosen DESC limit 10");
		return $hasil;
	}

	function get_kategori_for_blog(){
		$hasil=$this->db->query("SELECT COUNT(akademik_nik) AS jml,nik,kategori_nama FROM tbl_dosen JOIN tbl_kategori ON akademik_nik=nik GROUP BY akademik_nik");
		return $hasil;
	}
	

}