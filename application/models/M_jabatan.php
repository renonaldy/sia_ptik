<?php
class M_jabatan extends CI_Model{

	function get_all_jabatan(){
		$hsl=$this->db->query("select * from tbl_jabatan");
		return $hsl;
	}
	function simpan_jabatan($jabatan){
		$hsl=$this->db->query("insert into tbl_jabatan(jabatan_nama) values('$jabatan')");
		return $hsl;
	}
	function update_jabatan($kode,$jabatan){
		$hsl=$this->db->query("update tbl_jabatan set jabatan_nama='$jabatan' where jabatan_id='$kode'");
		return $hsl;
	}
	function hapus_jabatan($kode){
		$hsl=$this->db->query("delete from tbl_jabatan where jabatan_id='$kode'");
		return $hsl;
	}
	
	function get_jabatan_byid($jabatan_id){
		$hsl=$this->db->query("select * from tbl_jabatan where jabatan_id='$jabatan_id'");
		return $hsl;
	}

}