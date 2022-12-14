<?php
class M_alumni extends CI_Model{

	function get_all_alumni(){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni ORDER BY alumni_id DESC");
		return $hsl;
	}
	function get_all_alumni_kirim(){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni  where alumni_status='0' ORDER BY alumni_id DESC");
		return $hsl;
	}

	function simpan_alumni($judul,$isi,$kategori_alumni_id,$kategori_alumni_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("insert into tbl_alumni(alumni_judul,alumni_isi,alumni_kategori_alumni_id,alumni_kategori_nama,alumni_pengguna_id,alumni_author,alumni_gambar,alumni_slug,alumni_status) values ('$judul','$isi','$kategori_alumni_id','$kategori_alumni_nama','$user_id','$user_nama','$gambar','$slug','1')");
		return $hsl;
	}
	function get_alumni_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni where alumni_id='$kode'");
		return $hsl;
	}
	function update_alumni($alumni_id,$judul,$isi,$kategori_alumni_id,$kategori_alumni_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("update tbl_alumni set alumni_judul='$judul',alumni_isi='$isi',alumni_kategori_alumni_id='$kategori_alumni_id',alumni_kategori_nama='$kategori_alumni_nama',alumni_pengguna_id='$user_id',alumni_author='$user_nama',alumni_gambar='$gambar',alumni_slug='$slug',alumni_status='1' where alumni_id='$alumni_id'");
		return $hsl;
	}
	function update_alumni_tanpa_img($alumni_id,$judul,$isi,$kategori_alumni_id,$kategori_alumni_nama,$user_id,$user_nama,$slug){
		$hsl=$this->db->query("update tbl_alumni set alumni_judul='$judul',alumni_isi='$isi',alumni_kategori_alumni_id='$kategori_alumni_id',alumni_kategori_nama='$kategori_alumni_nama',alumni_pengguna_id='$user_id',alumni_author='$user_nama',alumni_slug='$slug',alumni_status='1' where alumni_id='$alumni_id'");
		return $hsl;
	}
	function hapus_alumni($kode){
		$hsl=$this->db->query("delete from tbl_alumni where alumni_id='$kode'");
		return $hsl;
	}



	//Front-End

	function get_post_home(){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d %M %Y') AS tanggal FROM tbl_alumni where alumni_status='1' ORDER BY alumni_id DESC limit 6");
		return $hsl;
	}

	function get_berita_slider(){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni where alumni_img_slider='1' ORDER BY alumni_id DESC");
		return $hsl;
	}

	function berita_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni ORDER BY alumni_id DESC limit $offset,$limit");
		return $hsl;
	}

	function berita(){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni ORDER BY alumni_id DESC");
		return $hsl;
	} 
	function get_berita_by_slug($slug){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni where alumni_slug='$slug'");
		return $hsl;
	}

	function get_alumni_by_kategori($kategori_alumni_id){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni where alumni_kategori_alumni_id='$kategori_alumni_id'");
		return $hsl;
	}

	function get_alumni_by_kategori_perpage($kategori_alumni_id,$offset,$limit){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni where alumni_kategori_alumni_id='$kategori_alumni_id' limit $offset,$limit");
		return $hsl;
	}

	function search_tulisan($keyword){
		$hsl=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_alumni WHERE alumni_judul LIKE '%$keyword%'");
		return $hsl;
	}

	function post_komentar($nama,$email,$web,$msg,$alumni_id){
		$hsl=$this->db->query("INSERT INTO tbl_komentar (komentar_nama,komentar_email,komentar_web,komentar_isi,komentar_alumni_id) VALUES ('$nama','$email','$web','$msg','$alumni_id')");
		return $hsl;
	}


	function count_views($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_views WHERE views_ip='$user_ip' AND views_alumni_id='$kode' AND DATE(views_tanggal)=CURDATE()");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_views (views_ip,views_alumni_id) VALUES('$user_ip','$kode')");
				$this->db->query("UPDATE tbl_alumni SET alumni_views=alumni_views+1 where alumni_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_alumni_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_alumni_id) VALUES('$user_ip','1','$kode')");
				$this->db->query("UPDATE tbl_alumni SET tulisan_rating=tulisan_rating+1 where alumni_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_alumni_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_alumni_id) VALUES('$user_ip','2','$kode')");
				$this->db->query("UPDATE tbl_alumni SET tulisan_rating=tulisan_rating+2 where alumni_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_alumni_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_alumni_id) VALUES('$user_ip','3','$kode')");
				$this->db->query("UPDATE tbl_alumni SET tulisan_rating=tulisan_rating+3 where alumni_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_alumni_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_alumni_id) VALUES('$user_ip','4','$kode')");
				$this->db->query("UPDATE tbl_alumni SET tulisan_rating=tulisan_rating+4 where alumni_id='$kode'");
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
        $hsl=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_alumni_id='$kode'");
        return $hsl;
    }


    function get_alumni_populer(){
		$hasil=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d %M %Y') AS tanggal FROM tbl_alumni ORDER BY tulisan_views DESC limit 10");
		return $hasil;
	}

	function get_alumni_terbaru(){
		$hasil=$this->db->query("SELECT tbl_alumni.*,DATE_FORMAT(alumni_tanggal,'%d %M %Y') AS tanggal FROM tbl_alumni ORDER BY alumni_id DESC limit 10");
		return $hasil;
	}

	function get_kategori_for_blog(){
		$hasil=$this->db->query("SELECT COUNT(alumni_kategori_alumni_id) AS jml,kategori_alumni_id,kategori_nama FROM tbl_alumni JOIN tbl_kategori ON alumni_kategori_alumni_id=kategori_alumni_id GROUP BY alumni_kategori_alumni_id");
		return $hasil;
	}
	

}