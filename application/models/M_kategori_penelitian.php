<?php
class M_kategori_penelitian extends CI_Model{

	function get_all_kategori_penelitian(){
		$hsl=$this->db->query("select * from tbl_kategori_penelitian");
		return $hsl;
	}
	function simpan_kategori_penelitian($kategori_penelitian){
		$hsl=$this->db->query("insert into tbl_kategori_penelitian(kategori_penelitian_nama) values('$kategori_penelitian')");
		return $hsl;
	}
	function update_kategori_penelitian($kode,$kategori_penelitian){
		$hsl=$this->db->query("update tbl_kategori_penelitian set kategori_penelitian_nama='$kategori_penelitian' where kategori_penelitian_id='$kode'");
		return $hsl;
	}
	function hapus_kategori_penelitian($kode){
		$hsl=$this->db->query("delete from tbl_kategori_penelitian where kategori_penelitian_id='$kode'");
		return $hsl;
	}
	
	function get_kategori_penelitian_byid($kategori_penelitian_id){
		$hsl=$this->db->query("select * from tbl_kategori_penelitian where kategori_penelitian_id='$kategori_penelitian_id'");
		return $hsl;
	}

}