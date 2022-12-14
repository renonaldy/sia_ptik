<?php
class M_kategori_akademik extends CI_Model{

	function get_all_kategori_akademik(){
		$hsl=$this->db->query("select * from tbl_kategori_akademik");
		return $hsl;
	}
	function simpan_kategori_akademik($kategori_akademik){
		$hsl=$this->db->query("insert into tbl_kategori_akademik(kategori_akademik_nama) values('$kategori_akademik')");
		return $hsl;
	}
	function update_kategori_akademik($kode,$kategori_akademik){
		$hsl=$this->db->query("update tbl_kategori_akademik set kategori_akademik_nama='$kategori_akademik' where kategori_akademik_id='$kode'");
		return $hsl;
	}
	function hapus_kategori_akademik($kode){
		$hsl=$this->db->query("delete from tbl_kategori_akademik where kategori_akademik_id='$kode'");
		return $hsl;
	}
	
	function get_kategori_akademik_byid($kategori_akademik_id){
		$hsl=$this->db->query("select * from tbl_kategori_akademik where kategori_akademik_id='$kategori_akademik_id'");
		return $hsl;
	}

}