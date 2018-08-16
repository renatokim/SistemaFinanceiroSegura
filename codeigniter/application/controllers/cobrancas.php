<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cobrancas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('cobranca', 'banco'); 
	}

	public function index()
	{
		$this->load->view('cobrancas/cobrancas');
	}

	public function create(){
		$dadosPost = $this->input->post(); //echo '<pre>'; print_r($dadosPost); die();

		$dados['valor'] = str_replace(',', '.', $dadosPost['valor']);
		$dados['numero_doc'] = strtoupper($dadosPost['numero_doc']);
		$dados['data_emissao'] = $dadosPost['data_entrada'];

		$dados['historico'] = $dadosPost['historico'];


		$dados['id_conta_corrente'] = $dadosPost['id_conta_corrente'];
		$dados['conta_caixa'] = $dadosPost['conta_caixa'];		
		
		$this->banco->save($dados);
		redirect(base_url().'index.php/cobrancas/read/'.$dadosPost['data_inicial'].'/'.$dadosPost['data_final']);
	}

	public function read($dt_ini = NULL, $dt_fin = NULL){
	
		$this->load->model('cobranca', 'banco');
	
		$dados = $this->input->post();
		if($dados == NULL && $dt_ini == NULL){
			$this->load->view('cobrancas/cob_data');
		}
		else if($dt_ini == NULL){ 
			$result['cobrancas'] = $this->banco->get($dados);
			$result['data_inicial'] = $dados['data_inicial'];
			$result['data_final'] = $dados['data_final'];
//echo '<pre>'; print_r($result); die('abcd');
			$this->load->view('cobrancas/cobrancas', $result);
			$this->load->view('cobrancas/cob_read', $result);
		}
		else {
			$dados['data_inicial'] = $dt_ini;
			$dados['data_final'] = $dt_fin;
			$result['cobrancas'] = $this->banco->get($dados);
			$result['data_inicial'] = $dados['data_inicial'];
			$result['data_final'] = $dados['data_final'];

			$this->load->view('cobrancas/cobrancas', $result);
			$this->load->view('cobrancas/cob_read', $result);
		}
	}
	
	public function editar($id, $dt_ini, $dt_fin){
		$data['cob'] = $this->banco->edit_load($id);
		$data['data_inicial'] = $dt_ini;
		$data['data_final'] = $dt_fin;

		$data['cob'][0]['historico'] = str_replace(" ", "_", $data['cob'][0]['historico']);
	
		$dados['data_inicial'] = $dt_ini;
		$dados['data_final'] = $dt_fin;
        $result['cobrancas'] = $this->banco->get($dados);
        
		$this->load->view('cobrancas/cob_edit', $data);
		$this->load->view('cobrancas/cob_read', $result);
	}	
	
	public function update(){
		$dadosPost = $this->input->post(); //echo '<pre>'; print_r($dadosPost); die();

		$dados['valor'] = str_replace(',', '.', $dadosPost['valor']);
		$dados['numero_doc'] = strtoupper($dadosPost['numero_doc']);
		$dados['data_entrada'] = $dadosPost['data_entrada'];
		$dados['data_emissao'] = $dadosPost['data_emissao'];
		$dados['data_bom_p'] = $dadosPost['data_bom_p'];
		$dados['historico'] = str_replace("_", " ", $dadosPost['historico']); 
		$dados['obs'] = $dadosPost['obs'];
		$dados['destinacao'] = $dadosPost['destinacao'];
		$dados['id_conta_corrente'] = $dadosPost['id_conta_corrente'];
		$dados['conta_caixa'] = $dadosPost['conta_caixa'];		
	//echo '<pre>'; print_r($dados); die();	
		$id = $dadosPost['id'];	
		$data_rel['dt_inicial'] = $dadosPost['data_inicial'];
		$data_rel['dt_final'] = $dadosPost['data_final'];
		
		$this->db->where('id', $id);
		$this->db->update('extratos', $dados); 
		redirect(base_url().'index.php/cobrancas/read' . '/' . $data_rel['dt_inicial'] . '/' . $data_rel['dt_final']);
	}	
	
	public function delete($id, $dt_ini, $dt_fin){
		$data['dt_inicial'] = $dt_ini;
		$data['dt_final'] = $dt_fin;
		$this->banco->del($id); 
		redirect(base_url().'index.php/cobrancas/read' . '/' . $data['dt_inicial'] . '/' . $data['dt_final']);
	}
	
	

	
}
