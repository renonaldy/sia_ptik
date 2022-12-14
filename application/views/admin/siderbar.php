<?php 
    $query=$this->db->query("SELECT * FROM tbl_inbox WHERE inbox_status='1'");
    $jum_pesan=$query->num_rows();

?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Menu Utama</li>
        <li class="active">
          <a href="<?php echo base_url().'admin/dashboard'?>">
            <i class="fa fa-home"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>

          <!-- Menu Akademik -->
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-book"></i>
            <span>Akademik</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="<?php echo base_url().'admin/akademik/add_akademik'?>"><i class="fa fa-plus"></i> Tambah</a></li>
           <li><a href="<?php echo base_url().'admin/akademik'?>"><i class="fa fa-align-justify"></i> List Menu</a></li>
           <li><a href="<?php echo base_url().'admin/Kategori_akademik'?>"><i class="fa fa-caret-square-o-right"></i> Kategori</a></li>
          </ul>
        </li>
           <!-- Menu Administrasi -->
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-bookmark"></i>
            <span>Administrasi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="<?php echo base_url().'admin/administrasi/add_administrasi'?>"><i class="fa fa-plus"></i> Tambah</a></li>
           <li><a href="<?php echo base_url().'admin/administrasi'?>"><i class="fa fa-align-justify"></i> List Menu Administrasi</a></li>
           <li><a href="<?php echo base_url().'admin/Kategori_administrasi'?>"><i class="fa fa-caret-square-o-right"></i> Kategori Administrasi</a></li>
          </ul>
        </li>
        <!-- Menu Dosen -->  
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder-open"></i>
            <span>Dosen</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url().'admin/dosen'?>"><i class="fa fa-user"></i> Biodata</a></li>
           <li><a href="<?php echo base_url().'admin/penelitian'?>"><i class="fa fa-file-word-o"></i> Penelitian</a></li>
           <li><a href="<?php echo base_url().'admin/kategori_penelitian'?>"><i class="fa fa-caret-square-o-right"></i> Kategori Penelitian</a></li>
           <li><a href="<?php echo base_url().'admin/jabatan'?>"><i class="fa fa-caret-square-o-right"></i> Kategori Jabatan</a></li> 
           <li><a href="<?php echo base_url().'admin/pangkat'?>"><i class="fa fa-caret-square-o-right"></i> Kategori Pangkat</a></li> 
          </ul>
        </li>
        <!-- Menu ALumni -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-mortar-board"></i>
            <span>Alumni</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="<?php echo base_url().'admin/alumni/add_alumni'?>"><i class="fa fa-plus"></i> Tambah</a></li>
           <li><a href="<?php echo base_url().'admin/alumni'?>"><i class="fa fa-align-justify"></i> List Menu</a></li>
           <li><a href="<?php echo base_url().'admin/Kategori_alumni'?>"><i class="fa fa-caret-square-o-right"></i> Kategori</a></li>
          </ul>
        </li>
        <!-- Menu Berita -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar-check-o"></i>
            <span>Post Berita </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="<?php echo base_url().'admin/tulisan/add_tulisan'?>"><i class="fa fa-thumb-tack"></i> Post Berita</a></li>
           <li><a href="<?php echo base_url().'admin/tulisan'?>"><i class="fa fa-align-justify"></i> List Berita </a></li>
           <li><a href="<?php echo base_url().'admin/Kategori'?>"><i class="fa fa-caret-square-o-right"></i> Kategori Berita </a></li>
            <li><a href="<?php echo base_url().'admin/tulisan/tulisanUser'?>"><i class="fa fa-file-text-o"></i> Pengajuan Berita</a></li>
          </ul>
        </li>
        <!-- Menu User Dosen -->
        <li>
          <a href="<?php echo base_url().'admin/mahasiswa'?>">
            <i class="fa fa-user"></i> <span> Data Akun Dosen</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        <!-- Menu User Mahasiswa -->
        <li>
          <a href="<?php echo base_url().'admin/mahasiswa'?>">
            <i class="fa fa-users"></i> <span> Data Akun Mahasiswa</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        <!-- Menu HMMPS -->
        <li>
          <a href="<?php echo base_url().'admin/Album'?>">
            <i class="fa fa-image"></i> <span> Kegiatan</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>


        <!-- Menu User Admin -->
        <li>
          <a href="<?php echo base_url().'admin/pengguna'?>">
            <i class="fa fa-user"></i> <span> Data Pengguna</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>

        <!-- Menu Pesan dari User -->
        <li>
          <a href="<?php echo base_url().'admin/inbox'?>">
            <i class="fa fa-envelope"></i> <span>Inbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"><?php echo $jum_pesan;?></small>
            </span>
          </a>
        </li>
        <!-- Keluar -->
         <li>
          <a href="<?php echo base_url().'administrator/logout'?>">
            <i class="fa fa-sign-out"></i> <span>LogOut</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        
       
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>