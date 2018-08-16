<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends CI_Controller {

	public function index()
	{
		$this->db->order_by('relatorio'); 
		$dados['relatorios'] = $this->db->get('cad_relatorio')->result_array(); 
		
		$this->load->view('relatorios/add_relatorio');
		$this->load->view('relatorios/select_relatorio', $dados);
	}

	public function cadastrar()
	{
		$dados = $this->input->post();
		print_r($dados);
		$this->db->insert('cad_relatorio', $dados);
		redirect('relatorios'); 
	}

	public function excluir($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cad_relatorio');

		$this->db->where('cad_relatorio_id', $id);
		$this->db->delete('cad_grupo_relatorio');

		$this->db->where('sequencia', $id);
		$this->db->delete('cad_cntcx_grupo_relatorio');		

		redirect('relatorios');
	}

	public function form_editar($id)
	{
		$relatorio['relatorio'] = $this->db->get_where('cad_relatorio', array('id' => $id))->result_array();
		$this->load->view('relatorios/form_editar', $relatorio);
	}


	public function editar()
	{
		$dados = $this->input->post();//print_r($dados); die();
		$dados_set['relatorio'] = str_replace('_', ' ', $dados['relatorio']);
		
		$this->db->where('id', $dados['id']);
		$this->db->update('cad_relatorio', $dados_set); 

		redirect('relatorios');
	}	



}

