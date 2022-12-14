<?php
class M_kategori_alumni extends CI_Model{

	function get_all_kategori_alumni(){
		$hsl=$this->db->query("select * from tbl_kategori_alumni");
		return $hsl;
	}
	function simpan_kategori_alumni($kategori_alumni){
		$hsl=$this->db->query("insert into tbl_kategori_alumni(kategori_alumni_nama) values('$kategori_alumni')");
		return $hsl;
	}
	function update_kategori_alumni($kode,$kategori_alumni){
		$hsl=$this->db->query("update tbl_kategori_alumni set kategori_alumni_nama='$kategori_alumni' where kategori_alumni_id='$kode'");
		return $hsl;
	}
	function hapus_kategori_alumni($kode){
		$hsl=$this->db->query("delete from tbl_kategori_alumni where kategori_alumni_id='$kode'");
		return $hsl;
	}
	
	function get_kategori_alumni_byid($kategori_alumni_id){
		$hsl=$this->db->query("select * from tbl_kategori_alumni where kategori_alumni_id='$kategori_alumni_id'");
		return $hsl;
	}

}