<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori extends CI_Controller {
	public function detail(){
		$query = $this->model_utama->view_where('kategori',array('kategori_seo' => $this->uri->segment(3)));
		if ($query->num_rows()<=0){
			redirect('main');
		}else{
			$row = $query->row_array();
			$jumlah= $this->model_utama->view_where('berita',array('id_kategori' => $row['id_kategori']))->num_rows();
			$config['base_url'] = base_url().'kategori/detail/'.$this->uri->segment(3);
			$config['total_rows'] = $jumlah;
			$config['per_page'] = 15; 	
			if ($this->uri->segment('4')==''){
				$dari = 0;
			}else{
				$dari = $this->uri->segment('4');
			}
			$data['title'] = "Berita Kategori $row[nama_kategori]";
			$data['description'] = description();
			$data['keywords'] = keywords();
			$data['rows'] = $row;
			$data['kategori'] = $this->model_utama->view('kategori');
			
			if (is_numeric($dari)) {
				$data['beritakategori'] = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('berita.status' => 'Y','berita.id_kategori' => $row['id_kategori']),'id_berita','DESC',$dari,$config['per_page']);
			}else{
				redirect('main');
			}
			$this->pagination->initialize($config);
			$this->template->load(template().'/template',template().'/detailkategori',$data);
		}
	}

	public function getMitra(){

		$query = $this->model_utama->cekMitra()->row_array();
		if (empty($query)){
			redirect('main');
		}else{
			$jumlah= $this->model_utama->cekMitra()->num_rows();
			$config['base_url'] = base_url().'kategori/getMitra/'.$this->uri->segment(3);
			$config['total_rows'] = $jumlah;
			$config['per_page'] = 15; 	
			if ($this->uri->segment('4')==''){
				$dari = 0;
			}else{
				$dari = $this->uri->segment('4');
			}
			$data['title'] = "Mitra $query[mitra_name]";
			$data['description'] = description();
			$data['keywords'] = keywords();
			$data['rows'] = $query;
			$data['mitra'] = $this->model_utama->view('mitra');
			
			if (is_numeric($dari)) {
				$data['mitraname'] = $this->model_utama->cekMitra();
			}else{
				redirect('main');
			}
			$this->pagination->initialize($config);
			$this->template->load(template().'/template',template().'/cekMitra',$data);
		}
	}

	public function getKarir(){

		$query = $this->model_utama->cekKarir()->row_array();
		if (empty($query)){
			redirect('main/blankPage');
		}else{
			$jumlah= $this->model_utama->cekKarir()->num_rows();
			$config['base_url'] = base_url().'kategori/getKarir/'.$this->uri->segment(3);
			$config['total_rows'] = $jumlah;
			$config['per_page'] = 15; 	
			if ($this->uri->segment('4')==''){
				$dari = 0;
			}else{
				$dari = $this->uri->segment('4');
			}
			$data['title'] = "Karir $query[karir_name]";
			$data['description'] = description();
			$data['keywords'] = keywords();
			$data['rows'] = $query;
			$data['mitra'] = $this->model_utama->view('karir');
			
			if (is_numeric($dari)) {
				$data['karirname'] = $this->model_utama->cekKarir()();
			}else{
				redirect('main');
			}
			$this->pagination->initialize($config);
			$this->template->load(template().'/template',template().'/cekKarir',$data);
		}
	}
}
