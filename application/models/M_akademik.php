<?php
class M_akademik extends CI_Model{

	function get_all_akademik(){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik ORDER BY akademik_id DESC");
		return $hsl;
	}
	function get_all_akademik_kirim(){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik  where akademik_status='0' ORDER BY akademik_id DESC");
		return $hsl;
	}

	function simpan_akademik($judul,$isi,$kategori_akademik_id,$kategori_akademik_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("insert into tbl_akademik(akademik_judul,akademik_isi,akademik_kategori_id,akademik_kategori_nama,akademik_pengguna_id,akademik_author,akademik_gambar,akademik_slug,akademik_status) values ('$judul','$isi','$kategori_akademik_id','$kategori_akademik_nama','$user_id','$user_nama','$gambar','$slug','1')");
		return $hsl;
	}
	function get_akademik_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik where akademik_id='$kode'");
		return $hsl;
	}
	function update_akademik($akademik_id,$judul,$isi,$kategori_akademik_id,$kategori_akademik_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("update tbl_akademik set akademik_judul='$judul',akademik_isi='$isi',akademik_kategori_id='$kategori_akademik_id',akademik_kategori_nama='$kategori_akademik_nama',akademik_pengguna_id='$user_id',akademik_author='$user_nama',akademik_gambar='$gambar',akademik_slug='$slug',akademik_status='1' where akademik_id='$akademik_id'");
		return $hsl;
	}
	function update_akademik_tanpa_img($akademik_id,$judul,$isi,$kategori_akademik_id,$kategori_akademik_nama,$user_id,$user_nama,$slug){
		$hsl=$this->db->query("update tbl_akademik set akademik_judul='$judul',akademik_isi='$isi',akademik_kategori_id='$kategori_akademik_id',akademik_kategori_nama='$kategori_akademik_nama',akademik_pengguna_id='$user_id',akademik_author='$user_nama',akademik_slug='$slug',akademik_status='1' where akademik_id='$akademik_id'");
		return $hsl;
	}
	function hapus_akademik($kode){
		$hsl=$this->db->query("delete from tbl_akademik where akademik_id='$kode'");
		return $hsl;
	}



	//Front-End

	function get_post_home(){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d %M %Y') AS tanggal FROM tbl_akademik where akademik_status='1' ORDER BY akademik_id DESC limit 6");
		return $hsl;
	}

	function get_berita_slider(){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik where akademik_img_slider='1' ORDER BY akademik_id DESC");
		return $hsl;
	}

	function berita_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik ORDER BY akademik_id DESC limit $offset,$limit");
		return $hsl;
	}

	function berita(){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik ORDER BY akademik_id DESC");
		return $hsl;
	} 
	function get_berita_by_slug($slug){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik where akademik_slug='$slug'");
		return $hsl;
	}

	function get_akademik_by_kategori($kategori_akademik_id){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik where akademik_kategori_id='$kategori_akademik_id'");
		return $hsl;
	}

	function get_akademik_by_kategori_perpage($kategori_akademik_id,$offset,$limit){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik where akademik_kategori_id='$kategori_akademik_id' limit $offset,$limit");
		return $hsl;
	}

	function search_tulisan($keyword){
		$hsl=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_akademik WHERE akademik_judul LIKE '%$keyword%'");
		return $hsl;
	}

	function post_komentar($nama,$email,$web,$msg,$akademik_id){
		$hsl=$this->db->query("INSERT INTO tbl_komentar (komentar_nama,komentar_email,komentar_web,komentar_isi,komentar_akademik_id) VALUES ('$nama','$email','$web','$msg','$akademik_id')");
		return $hsl;
	}


	function count_views($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_views WHERE views_ip='$user_ip' AND views_akademik_id='$kode' AND DATE(views_tanggal)=CURDATE()");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_views (views_ip,views_akademik_id) VALUES('$user_ip','$kode')");
				$this->db->query("UPDATE tbl_akademik SET akademik_views=akademik_views+1 where akademik_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_akademik_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_akademik_id) VALUES('$user_ip','1','$kode')");
				$this->db->query("UPDATE tbl_akademik SET tulisan_rating=tulisan_rating+1 where akademik_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_akademik_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_akademik_id) VALUES('$user_ip','2','$kode')");
				$this->db->query("UPDATE tbl_akademik SET tulisan_rating=tulisan_rating+2 where akademik_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_akademik_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_akademik_id) VALUES('$user_ip','3','$kode')");
				$this->db->query("UPDATE tbl_akademik SET tulisan_rating=tulisan_rating+3 where akademik_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_akademik_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_akademik_id) VALUES('$user_ip','4','$kode')");
				$this->db->query("UPDATE tbl_akademik SET tulisan_rating=tulisan_rating+4 where akademik_id='$kode'");
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
        $hsl=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_akademik_id='$kode'");
        return $hsl;
    }


    function get_akademik_populer(){
		$hasil=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d %M %Y') AS tanggal FROM tbl_akademik ORDER BY tulisan_views DESC limit 10");
		return $hasil;
	}

	function get_akademik_terbaru(){
		$hasil=$this->db->query("SELECT tbl_akademik.*,DATE_FORMAT(akademik_tanggal,'%d %M %Y') AS tanggal FROM tbl_akademik ORDER BY akademik_id DESC limit 10");
		return $hasil;
	}

	function get_kategori_for_blog(){
		$hasil=$this->db->query("SELECT COUNT(akademik_kategori_id) AS jml,kategori_akademik_id,kategori_nama FROM tbl_akademik JOIN tbl_kategori ON akademik_kategori_id=kategori_akademik_id GROUP BY akademik_kategori_id");
		return $hasil;
	}
	

}