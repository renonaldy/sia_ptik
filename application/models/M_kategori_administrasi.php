<?php
class M_kategori_administrasi extends CI_Model{

	function get_all_kategori_administrasi(){
		$hsl=$this->db->query("select * from tbl_kategori_administrasi");
		return $hsl;
	}
	function simpan_kategori_administrasi($kategori_administrasi){
		$hsl=$this->db->query("insert into tbl_kategori_administrasi(kategori_administrasi_nama) values('$kategori_administrasi')");
		return $hsl;
	}
	function update_kategori_administrasi($kode,$kategori_administrasi){
		$hsl=$this->db->query("update tbl_kategori_administrasi set kategori_administrasi_nama='$kategori_administrasi' where kategori_administrasi_id='$kode'");
		return $hsl;
	}
	function hapus_kategori_administrasi($kode){
		$hsl=$this->db->query("delete from tbl_kategori_administrasi where kategori_administrasi_id='$kode'");
		return $hsl;
	}
	
	function get_kategori_administrasi_byid($kategori_administrasi_id){
		$hsl=$this->db->query("select * from tbl_kategori_administrasi where kategori_administrasi_id='$kategori_administrasi_id'");
		return $hsl;
	}

}