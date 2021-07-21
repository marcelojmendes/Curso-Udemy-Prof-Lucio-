<?php 
    defined('BASEPATH') OR exit('Ação não permitida.');

    class Usuarios extends CI_Controller{

    	public function __construct(){
    		parent::__construct();
    	}

        //Dentro da funçao index, carrego a view do index q ta la dentro de usuario.. para listar
    	public function index(){
            //Dentro do array tera os usuario cadastrados do banco.

    		$data = array(

                //Definindo a variavel do tipo array, chamada titulo, q ta no nosso index para usuarios
                'titulo' => 'Usuários Cadastrados',


                //Criando uma chave q e um array, carregando o arquivo de estilo da tabela
                       'styles' => array(
                            'vendor/datatables/dataTables.bootstrap4.min.css',
                        ),

                        'scripts' => array(
                            'vendor/datatables/jquery.dataTables.min.js',
                            'vendor/datatables/dataTables.bootstrap4.min.js',
                            'vendor/datatables/app.js'
                        ),
                       


                               //essa funçao recupera os usuarios, peguei ela la na documentaçao do ion_auth 
    			'usuarios' => $this->ion_auth->users()->result(),
    		);
            /*Verificar se esta vindo alguma informaçao do meu banco pra minha view
    		echo '<prev>';
    		print_r($data['usuarios']);
    		exit(); */

    		//Agora irei carregar nossas views, adicionei o arrei data para a view n ficar em branco.
    		$this->load->view('layout/header', $data);
    		$this->load->view('usuarios/index');
    		$this->load->view('layout/footer');
    	}

        public function edit($usuario_id = NULL){

            if(!$usuario_id || !$this->ion_auth->user($usuario_id)->row()){

                $this->session->set_flashdata('error', 'Usuario não encontrado!');
                redirect('usuarios');
            }else{
                

     

                $this->form_validation->set_rules('first_name','','trim|required');
                $this->form_validation->set_rules('last_name', '', 'trim|required');
                $this->form_validation->set_rules('email', '', 'trim|required|valid_email|callback_email_check');
                $this->form_validation->set_rules('username', '', 'trim|required');
                $this->form_validation->set_rules('password', 'senha', 'min_length[5]|max_length[255]');
                $this->form_validation->set_rules('confirm_password', 'confirma', 'matches[password]');

                if($this->form_validation->run()){
                    exit('Validado');

                }else{
                    $data = array(

                    'titulo' => 'Editar usuario',
                    'usuario' => $this->ion_auth->user($usuario_id)->row(),
                    'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                );
                    $this->load->view('layout/header', $data);
                    $this->load->view('usuarios/edit');
                    $this->load->view('layout/footer');
                }

                
            }

            
        }

        public function email_check($email){

            $usuario_id = $this->input->post('usuario_id');

            if($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))){

                $this->form_validation->set_message('email_check','Esse e-mail já existe');
                return FALSE;

            }else{
                return TRUE;
            }
        } 
    }
 ?>