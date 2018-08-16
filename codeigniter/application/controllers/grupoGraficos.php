<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GrupoGraficos extends CI_Controller {

	public function getGrupos($id_grupo, $seq_grupo, $id_grafico)
	{
		# grupo
		$this->db->where('id', $id_grupo);
		$dados['grupo'] = $this->db->get('cadastro_grupos')->result_array();
		
		# conta caixas
		$where = array('id_grafico' => $id_grafico, 'seg_grupo' => $seq_grupo);
		$this->db->where($where);
		$this->db->order_by('conta_caixa');
		$dados['contaCaixas'] = $this->db->get('contacaixa_grupos')->result_array();
		
		# todos os conta caixas
		$dados['todosContaCaixas'] = $this->db->get('conta_caixa')->result_array();
		
		$this->load->view('grupoGraficos/getGrupos', $dados);
	}
	
	public function alterarGrupos()
	{
		$dados = $_POST;
		
		echo '<pre>';
		print_r($dados);
	
		$this->db->where('id', $dados['id_grupo']);
		$this->db->update('cadastro_grupos', array('nome_grupo' => $dados['nome_grupo']));
		
		$this->db->where('id_grafico', $dados['grafico']);
		$this->db->where('seg_grupo', $dados['sequencia']);
		$this->db->delete('contacaixa_grupos');
		
		foreach($dados['opt'] as $i => $c)
		{
			$this->db->insert('contacaixa_grupos', array('id_grafico' =>  $dados['grafico'], 'seg_grupo' => $dados['sequencia'], 'conta_caixa' => $c));
		}
		
		
		redirect('../../cadastro/lista_grupos.php');
	
	
	}
}
