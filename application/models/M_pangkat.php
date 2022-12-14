<?php
class M_pangkat extends CI_Model{

	function get_all_pangkat(){
		$hsl=$this->db->query("select * from tbl_pangkat");
		return $hsl;
	}
	function simpan_pangkat($pangkat){
		$hsl=$this->db->query("insert into tbl_pangkat(pangkat_nama) values('$pangkat')");
		return $hsl;
	}
	function update_pangkat($kode,$pangkat){
		$hsl=$this->db->query("update tbl_pangkat set pangkat_nama='$pangkat' where pangkat_id='$kode'");
		return $hsl;
	}
	function hapus_pangkat($kode){
		$hsl=$this->db->query("delete from tbl_pangkat where pangkat_id='$kode'");
		return $hsl;
	}
	
	function get_pangkat_byid($pangkat_id){
		$hsl=$this->db->query("select * from tbl_pangkat where pangkat_id='$pangkat_id'");
		return $hsl;
	}

}