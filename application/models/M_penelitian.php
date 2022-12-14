<?php
class M_penelitian extends CI_Model{

	function get_all_penelitian(){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian ORDER BY penelitian_id DESC");
		return $hsl;
	}
	function get_all_penelitian_kirim(){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian  where penelitian_status='0' ORDER BY penelitian_id DESC");
		return $hsl;
	}

	function simpan_penelitian($judul,$isi,$kategori_penelitian_id,$kategori_penelitian_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("insert into tbl_penelitian(penelitian_judul,penelitian_isi,penelitian_kategori_id,penelitian_kategori_nama,penelitian_pengguna_id,penelitian_author,penelitian_gambar,penelitian_slug,penelitian_status) values ('$judul','$isi','$kategori_penelitian_id','$kategori_penelitian_nama','$user_id','$user_nama','$gambar','$slug','1')");
		return $hsl;
	}
	function get_penelitian_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian where penelitian_id='$kode'");
		return $hsl;
	}
	function update_penelitian($penelitian_id,$judul,$isi,$kategori_penelitian_id,$kategori_penelitian_nama,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("update tbl_penelitian set penelitian_judul='$judul',penelitian_isi='$isi',penelitian_kategori_id='$kategori_penelitian_id',penelitian_kategori_nama='$kategori_penelitian_nama',penelitian_pengguna_id='$user_id',penelitian_author='$user_nama',penelitian_gambar='$gambar',penelitian_slug='$slug',penelitian_status='1' where penelitian_id='$penelitian_id'");
		return $hsl;
	}
	function update_penelitian_tanpa_img($penelitian_id,$judul,$isi,$kategori_penelitian_id,$kategori_penelitian_nama,$user_id,$user_nama,$slug){
		$hsl=$this->db->query("update tbl_penelitian set penelitian_judul='$judul',penelitian_isi='$isi',penelitian_kategori_id='$kategori_penelitian_id',penelitian_kategori_nama='$kategori_penelitian_nama',penelitian_pengguna_id='$user_id',penelitian_author='$user_nama',penelitian_slug='$slug',penelitian_status='1' where penelitian_id='$penelitian_id'");
		return $hsl;
	}
	function hapus_penelitian($kode){
		$hsl=$this->db->query("delete from tbl_penelitian where penelitian_id='$kode'");
		return $hsl;
	}



	//Front-End

	function get_post_home(){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d %M %Y') AS tanggal FROM tbl_penelitian where penelitian_status='1' ORDER BY penelitian_id DESC limit 6");
		return $hsl;
	}

	function get_berita_slider(){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian where penelitian_img_slider='1' ORDER BY penelitian_id DESC");
		return $hsl;
	}

	function berita_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian ORDER BY penelitian_id DESC limit $offset,$limit");
		return $hsl;
	}

	function berita(){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian ORDER BY penelitian_id DESC");
		return $hsl;
	} 
	function get_berita_by_slug($slug){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian where penelitian_slug='$slug'");
		return $hsl;
	}

	function get_penelitian_by_kategori($kategori_penelitian_id){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian where penelitian_kategori_id='$kategori_penelitian_id'");
		return $hsl;
	}

	function get_penelitian_by_kategori_perpage($kategori_penelitian_id,$offset,$limit){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian where penelitian_kategori_id='$kategori_penelitian_id' limit $offset,$limit");
		return $hsl;
	}

	function search_tulisan($keyword){
		$hsl=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_penelitian WHERE penelitian_judul LIKE '%$keyword%'");
		return $hsl;
	}

	function post_komentar($nama,$email,$web,$msg,$penelitian_id){
		$hsl=$this->db->query("INSERT INTO tbl_komentar (komentar_nama,komentar_email,komentar_web,komentar_isi,komentar_penelitian_id) VALUES ('$nama','$email','$web','$msg','$penelitian_id')");
		return $hsl;
	}


	function count_views($kode){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_views WHERE views_ip='$user_ip' AND views_penelitian_id='$kode' AND DATE(views_tanggal)=CURDATE()");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_views (views_ip,views_penelitian_id) VALUES('$user_ip','$kode')");
				$this->db->query("UPDATE tbl_penelitian SET penelitian_views=penelitian_views+1 where penelitian_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_penelitian_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_penelitian_id) VALUES('$user_ip','1','$kode')");
				$this->db->query("UPDATE tbl_penelitian SET tulisan_rating=tulisan_rating+1 where penelitian_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_penelitian_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_penelitian_id) VALUES('$user_ip','2','$kode')");
				$this->db->query("UPDATE tbl_penelitian SET tulisan_rating=tulisan_rating+2 where penelitian_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_penelitian_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_penelitian_id) VALUES('$user_ip','3','$kode')");
				$this->db->query("UPDATE tbl_penelitian SET tulisan_rating=tulisan_rating+3 where penelitian_id='$kode'");
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
        $cek_ip=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_penelitian_id='$kode'");
        if($cek_ip->num_rows() <= 0){
            $this->db->trans_start();
				$this->db->query("INSERT INTO tbl_post_rating (rate_ip,rate_point,rate_penelitian_id) VALUES('$user_ip','4','$kode')");
				$this->db->query("UPDATE tbl_penelitian SET tulisan_rating=tulisan_rating+4 where penelitian_id='$kode'");
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
        $hsl=$this->db->query("SELECT * FROM tbl_post_rating WHERE rate_ip='$user_ip' AND rate_penelitian_id='$kode'");
        return $hsl;
    }


    function get_penelitian_populer(){
		$hasil=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d %M %Y') AS tanggal FROM tbl_penelitian ORDER BY tulisan_views DESC limit 10");
		return $hasil;
	}

	function get_penelitian_terbaru(){
		$hasil=$this->db->query("SELECT tbl_penelitian.*,DATE_FORMAT(penelitian_tanggal,'%d %M %Y') AS tanggal FROM tbl_penelitian ORDER BY penelitian_id DESC limit 10");
		return $hasil;
	}

	function get_kategori_for_blog(){
		$hasil=$this->db->query("SELECT COUNT(penelitian_kategori_id) AS jml,kategori_penelitian_id,kategori_penelitian_nama FROM tbl_penelitian JOIN tbl_kategori ON penelitian_kategori_id=kategori_penelitian_id GROUP BY penelitian_kategori_id");
		return $hasil;
	}
	

}