<?php 
defined('BASEPATH') OR exit('Ação não permitida!'); 
//Model trata da comunicaçao com o banco
class Core_model extends CI_Model{
	//Criando uma funçao q recupera os dados da tabela q for passada, recebe um array chamada condicao
	public function get_all($tabela = NULL, $condicao = NULL){
		//Se a tabela for passada...
		if ($tabela) {
			//Se o condicao for passado e for um array...            
			if (is_array($condicao)) {
				//Entao executa um where conforme a condicao q foi passada no array condicao...
				$this->db->where($condicao);
			}
			//Se condicao for passado, mas n for um array, ele retorna todos os dados da tabela.
			return $this->db->get($tabela)->result();
		}else{
			//Se a tabela n for passada ele returna falso.
			return FALSE;
		}
	}
	//O ida vai receber uma condiçao e um table
    public function get_by_id($tabela = NULL, $condicao = NULL){
    	if ($tabela && is_array($condicao)) {
    		//Fazendo verificaçao se a tabela foi passada...
    		$this->db->where($condicao);
    		//Quando busca por id, e retorna uma linha apenas, coloca 1
    		$this->db->limit(1);

    		return $this->db->get($tabela)->row();
    	}
    	//Se nada disso for passado...
    	else{
    		return FALSE;
    	}

}//Inserindo dados na tabela
   public function insert($tabela = NULL, $data = NULL, $get_last_id = NULL){

   	//Verificação.. se nossa tabela foi passada, e data for um array
   	if($tabela && is_array($data)){

   		//Entao, insere o dado
   		$this->db->insert($tabela, $data);
        //Se foi passado como parametro essa informaçao do get_id, ele salva na nossa sessão
   		if($get_last_id){

   			$this->session->set_userdata('last_id', $this->db->insert_id());
   		}
   		//Se o numedo de linhas afetados, for maior q 0, lança na sessão a mensagem..
   		if($this-db->affected_rows() > 0){
   			$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');

   		}else{
   			$this->session->set_flashdata('error', 'Erro ao salvar dados');
   		}

   	}else{

   	}
   }

   //Criando funçao atualizar
   public function update($tabela = NULL, $data = NULL, $condicao = NULL){

   	//Fazendo verificação se os dois parametros foram passados! obs:sempre q fazer o if, estou vendo se foi passado os parametros.. se foi passado a tabela, e a variavel data e condicao forem um array, ele executa o codigo.
   	if($tabela && is_array($data) && is_array($condicao)){
         
         //Atualizar os dados na minha tabela
   		if (
   		$this->db->update($tabela, $data, $condicao)) {
   			//Apos tudo for atualizado na tabela, da uma messagem...
   			$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
   		}else{
   		//Se n salvar, da mensagem de erro para usuario.
   		$this->session->set_flashdata('error', 'Erro ao atualizar dados');
   	}
   	}else{
   		return FALSE;
   	}
   }
   //Criando funçao de deletar
   public function delete($tabela = NULL, $condicao = NULL){
//Antes de fazer a verificaçao com o if, desabilita o debug do framework codeigniter, e la no final de tudo, habilito ele novamente.
   	$this->db->db_debug = FALSE;

   	//Fazendo verificaçao com os dois parametros passados.. se foi passado a tabela e a variavel data for um array, executa o comando
   	if ($tabela && is_array($condicao)) {
   		// code...
   		$status = $this->db->delete($tabela, $condicao);

   		//Verifica se houve erro.
   		$error = $this->db->error();

   		//Se nossa variavel status nao for verdadeira.. !, abre um 
   		if(!status){
   			foreach ($error as $code){
   				//1451 e o numero do erro sql para identificar na web
   				if($code == 1451){

   					$this->session->set_flashdata('error', 'Esse registro não poderá ser deletado! pois estar sendo utilizado em outra tabela');
   				}
   			}
   		}else{
   			//Se nao houver erro, ele deleta o registro da tabela.
   			$this->session->set_flashdata('sucesso', 'Registro deletado com sucesso');
   		}
   		    $this->db->db_debug = TRUE;
   	}else{

   		return FALSE;
   	}

   }
}
?>