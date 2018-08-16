<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Chq_recebido extends CI_Model {
 
    function __construct(){
        parent::__construct();
    }
	
	public function save($dados){ //echo '<pre>'; print_r($dados);
		$this->db->insert('extratos', $dados);
	}
	
	public function get($dados){
	
	    $this->db->select('extratos.id as id');
	    $this->db->select('extratos.id_conta_corrente as id_conta_corrente');
	    $this->db->select('extratos.data_emissao as data_emissao');
	    $this->db->select('extratos.data_bom_p as data_bom_p');
	    $this->db->select('extratos.historico as historico');
	    $this->db->select('extratos.numero_doc as numero_doc');
	    $this->db->select('extratos.valor as valor');
	    $this->db->select('extratos.conta_caixa as conta_caixa');
	    $this->db->select('extratos.obs as obs');
	    $this->db->select('extratos.data_entrada as data_entrada');
	    $this->db->select('extratos.destinacao as destinacao');
	    $this->db->select('conta_caixa.descricao as descricao');
	    
	    $this->db->join('conta_caixa', 'conta_caixa.num_conta_caixa = extratos.conta_caixa');

		$this->db->where('data_entrada >=', $dados['data_inicial']);
		$this->db->where('data_entrada <=', $dados['data_final']);
		$this->db->where('id_conta_corrente', 18);
		$this->db->order_by('data_entrada');
		
		return $this->db->get('extratos')->result_array();
	}
	
	public function edit_load($id){
	
	    $this->db->select('extratos.id');
	    $this->db->select('extratos.id_conta_corrente as id_conta_corrente');
	    $this->db->select('extratos.data_emissao as data_emissao');
	    $this->db->select('extratos.data_bom_p as data_bom_p');
	    $this->db->select('extratos.historico as historico');
	    $this->db->select('extratos.numero_doc as numero_doc');
	    $this->db->select('extratos.valor as valor');
	    $this->db->select('extratos.conta_caixa as conta_caixa');
	    $this->db->select('extratos.obs as obs');
	    $this->db->select('extratos.data_entrada as data_entrada');
	    $this->db->select('extratos.destinacao as destinacao');
	    $this->db->select('conta_caixa.descricao as descricao');
	    
	    $this->db->join('conta_caixa', 'conta_caixa.num_conta_caixa = extratos.conta_caixa');
	    	
		$this->db->where('extratos.id', $id);
		return $this->db->get('extratos')->result_array();
	}
	
	
	public function del($id){
		$this->db->where('id', $id);
		$this->db->delete('extratos');
	}	
	
}