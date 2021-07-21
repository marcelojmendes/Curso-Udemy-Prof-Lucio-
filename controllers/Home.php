<?php 
defined('BASEPATH') OR exit('Ação não permitida! kkk');

//criando a class home, sempre com letra maiúscula
class Home extends CI_Controller{

	//criando nosso construtor..
	public function __construct(){
		parent::__construct();
	}
	//criando nosso methodo index. dentro dos parent, pode passar parametros
	public function index(){

		//Carregando nosso header la da pasta layout, no header tem os arquivos de css
		$this->load->view('layout/header');
		//Carregando a nossa view dentro de home e acessa index
		$this->load->view('home/index');
		//Carregando nosso footer q ta la na pasta layout, no footer tem os arquivos de javascript
		$this->load->view('layout/footer');
	}
}

 ?>