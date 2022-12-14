<?php
class M_administrasi extends CI_Model{

	function get_all_administrasi(){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi ORDER BY administrasi_id DESC");
		return $hsl;
	}
	function get_all_administrasi_kirim(){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi  where administrasi_status='0' ORDER BY administrasi_id DESC");
		return $hsl;
	}

	function simpan_administrasi($judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("insert into tbl_administrasi(administrasi_judul,administrasi_isi,administrasi_kategori_administrasi_id,administrasi_kategori_nama,administrasi_pengguna_id,administrasi_author,administrasi_gambar,administrasi_slug,administrasi_status) values ('$judul','$isi','$kategori_administrasi_id','$kategori_administrasi_nama','$user_id','$user_nama','$gambar','$slug','1')");
		return $hsl;
	}
	function get_administrasi_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi where administrasi_id='$kode'");
		return $hsl;
	}
	function update_administrasi($administrasi_id,$judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("update tbl_administrasi set administrasi_judul='$judul',administrasi_isi='$isi',administrasi_kategori_administrasi_id='$kategori_administrasi_id',administrasi_kategori_nama='$kategori_administrasi_nama',administrasi_pengguna_id='$user_id',administrasi_author='$user_nama',administrasi_gambar='$gambar',administrasi_slug='$slug',administrasi_status='1' where administrasi_id='$administrasi_id'");
		return $hsl;
	}
	function update_administrasi_tanpa_img($administrasi_id,$judul,$isi,$kategori_administrasi_id,$kategori_administrasi_nama,$user_id,$user_nama,$slug){
		$hsl=$this->db->query("update tbl_administrasi set administrasi_judul='$judul',administrasi_isi='$isi',administrasi_kategori_administrasi_id='$kategori_administrasi_id',administrasi_kategori_nama='$kategori_administrasi_nama',administrasi_pengguna_id='$user_id',administrasi_author='$user_nama',administrasi_slug='$slug',administrasi_status='1' where administrasi_id='$administrasi_id'");
		return $hsl;
	}
	function hapus_administrasi($kode){
		$hsl=$this->db->query("delete from tbl_administrasi where administrasi_id='$kode'");
		return $hsl;
	}



	//Front-End

	function get_post_home(){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d %M %Y') AS tanggal FROM tbl_administrasi where administrasi_status='1' ORDER BY administrasi_id DESC limit 6");
		return $hsl;
	}

	function get_berita_slider(){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi where administrasi_img_slider='1' ORDER BY administrasi_id DESC");
		return $hsl;
	}

	function berita_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi ORDER BY administrasi_id DESC limit $offset,$limit");
		return $hsl;
	}

	function berita(){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi ORDER BY administrasi_id DESC");
		return $hsl;
	} 
	function get_berita_by_slug($slug){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi where administrasi_slug='$slug'");
		return $hsl;
	}

	function get_administrasi_by_kategori($kategori_administrasi_id){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi where administrasi_kategori_administrasi_id='$kategori_administrasi_id'");
		return $hsl;
	}

	function get_administrasi_by_kategori_perpage($kategori_administrasi_id,$offset,$limit){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi where administrasi_kategori_administrasi_id='$kategori_administrasi_id' limit $offset,$limit");
		return $hsl;
	}

	function search_tulisan($keyword){
		$hsl=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_administrasi WHERE administrasi_judul LIKE '%$keyword%'");
		return $hsl;
	}

	function post_komentar($nama,$email,$web,$msg,$administrasi_id){
		$hsl=$this->db->query("INSERT INTO tbl_komentar (komentar_nama,komentar_email,komentar_web,komentar_isi,komentar_administrasi_id) VALUES ('$nama','$email','$web','$msg','$administrasi_id')");
		return $hsl;
	}


	function count_views($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_views WHERE views_ip='$user_ip' AND views_administrasi_id='$kode' AND DATE(views_tanggal)=CURDATE()");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_views (views_ip,views_administrasi_id) VALUES('$user_ip','$kode')");
				$this->db->query("UPDATE tbl_administrasi SET administrasi_views=administrasi_views+1 where administrasi_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_administrasi_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_administrasi_id) VALUES('$user_ip','1','$kode')");
				$this->db->query("UPDATE tbl_administrasi SET tulisan_rating=tulisan_rating+1 where administrasi_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_administrasi_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_administrasi_id) VALUES('$user_ip','2','$kode')");
				$this->db->query("UPDATE tbl_administrasi SET tulisan_rating=tulisan_rating+2 where administrasi_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_administrasi_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_administrasi_id) VALUES('$user_ip','3','$kode')");
				$this->db->query("UPDATE tbl_administrasi SET tulisan_rating=tulisan_rating+3 where administrasi_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_administrasi_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_administrasi_id) VALUES('$user_ip','4','$kode')");
				$this->db->query("UPDATE tbl_administrasi SET tulisan_rating=tulisan_rating+4 where administrasi_id='$kode'");
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
        $hsl=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_administrasi_id='$kode'");
        return $hsl;
    }


    function get_administrasi_populer(){
		$hasil=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d %M %Y') AS tanggal FROM tbl_administrasi ORDER BY tulisan_views DESC limit 10");
		return $hasil;
	}

	function get_administrasi_terbaru(){
		$hasil=$this->db->query("SELECT tbl_administrasi.*,DATE_FORMAT(administrasi_tanggal,'%d %M %Y') AS tanggal FROM tbl_administrasi ORDER BY administrasi_id DESC limit 10");
		return $hasil;
	}

	function get_kategori_for_blog(){
		$hasil=$this->db->query("SELECT COUNT(administrasi_kategori_administrasi_id) AS jml,kategori_administrasi_id,kategori_nama FROM tbl_administrasi JOIN tbl_kategori ON administrasi_kategori_administrasi_id=kategori_administrasi_id GROUP BY administrasi_kategori_administrasi_id");
		return $hasil;
	}
	

}