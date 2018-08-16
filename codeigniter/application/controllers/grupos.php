<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupos extends CI_Controller {

	public function index()
	{
		# GRUPOS
		$this->db->order_by('nome_grupo'); 
		$dados['grupos'] = $this->db->get('cad_grupo_relatorio')->result_array(); 

		# RELATORIOS
		$this->db->order_by('relatorio'); 
		$dados['relatorios'] = $this->db->get('cad_relatorio')->result_array();
		
		# CONTACAIXAS
		$this->db->order_by('num_conta_caixa'); 
		$dados['contacaixas'] = $this->db->get('conta_caixa')->result_array();

		# CARREGA AS VIEWS
		$this->load->view('grupos/add_grupo', $dados);
		//$this->load->view('grupos/select_grupo', $dados);
	}

	public function cadastrar()
	{
		$dados = $this->input->post();
		//echo '<pre>'; print_r($dados['conta_caixa']); die();

		$dados_cad['cad_relatorio_id'] = $dados['cad_relatorio_id'];
		$dados_cad['nome_grupo'] = $dados['nome_grupo'];
		
		# CADASTRO O GRUPO
		$this->db->insert('cad_grupo_relatorio', $dados_cad);

		$dados_cad_cntx['sequencia'] = $dados_cad['cad_relatorio_id'];
		$dados_cad_cntx['id_cad_grupo_relatorio'] = $this->db->insert_id();
		# CADASTRA OS CONTA-CAIXAS
		if(isset($dados['conta_caixa']))
		foreach ($dados['conta_caixa'] as $key => $contacaixa) {
			$dados_cad_cntx['conta_caixa'] = $contacaixa; //print_r($contacaixa);
			$this->db->insert('cad_cntcx_grupo_relatorio', $dados_cad_cntx);			
		}



		redirect('grupos'); 
	}

	public function excluir($id)
	{
		# EXCLUI GRUPO
		$this->db->where('id', $id);
		$this->db->delete('cad_grupo_relatorio');
		

		# EXCLUI OS CNTCX'S DO GRUPO
		$this->db->where('id_cad_grupo_relatorio', $id);
		$this->db->delete('cad_cntcx_grupo_relatorio');

		redirect('grupos/form_editar');
	}

	public function editar($id)
	{
		# GRUPO
		$this->db->where('id', $id);
		$grupo['grupo'] = $this->db->get('cad_grupo_relatorio')->result_array();

		# CONTA-CAIXA'S DO GRUPO
		$this->db->where('id_cad_grupo_relatorio', $id);
		$grupo['ctcx'] = $this->db->get(' cad_cntcx_grupo_relatorio')->result_array();	

		# CONTA-CAIXA'S
		$this->db->order_by('num_conta_caixa');
		$grupo['conta_caixa'] = $this->db->get('conta_caixa')->result_array();

		//echo '<pre>'; print_r($grupo);

		$this->load->view('grupos/editar_grupo', $grupo);
	}

	public function set_grupos()
	{

		$grupos = $this->input->post();

		$grupos['nome_grupo'] = str_replace('_', ' ', $grupos['nome_grupo']); 
		
		$id_grafico = $grupos['id_relatorio'];

		# ALTERA NOME GRUPO
		$this->db->where('id', $grupos['id']);
		$this->db->update('cad_grupo_relatorio', array('nome_grupo' => $grupos['nome_grupo']));

		# APAGA CTCX GRUPO
		$this->db->delete('cad_cntcx_grupo_relatorio', array('id_cad_grupo_relatorio' => $grupos['id'])); 		
		
		#  E INCLUI OS NOVO
		foreach ($grupos['conta_caixa'] as $k => $contacaixa) 
		{
			$ctcx['conta_caixa'] = $contacaixa;
			$ctcx['id_cad_grupo_relatorio'] = $grupos['id'];
			$ctcx['sequencia'] = $id_grafico;
			$this->db->insert('cad_cntcx_grupo_relatorio', $ctcx);
		}

		redirect('grupos/form_editar');
	}	


	public function form_editar()
	{
		$this->db->select('cad_grupo_relatorio.id as id_grupo');
		$this->db->select('cad_grupo_relatorio.cad_relatorio_id');
		$this->db->select('cad_grupo_relatorio.nome_grupo');
		
		$this->db->select('cad_relatorio.id as id_relatorio');
		$this->db->select('cad_relatorio.relatorio');

		$this->db->join('cad_relatorio', 'cad_relatorio.id = cad_grupo_relatorio.cad_relatorio_id');

		$this->db->order_by('cad_relatorio.id');
		$this->db->order_by('cad_grupo_relatorio.id');

		$dados['grupos'] = $this->db->get('cad_grupo_relatorio')->result_array();

		$this->load->view('grupos/form_editar', $dados);
	}
}

