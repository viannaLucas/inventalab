<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\ParticipanteModel;
use App\Entities\ParticipanteEntity;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseControllerParticipante extends Controller {

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    
    /**
     * Default itens in pagination
     */
    protected const itensPaginacao = 10;
    
    
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->verificarPermissao();
    }

    /**
     * Verifica se o usuário tem acesso ao recurso acessado
     * 
     * Se não possuir volta para página anterior, caso não esteja logado
     * é direcionado para página de login
     */
    private function verificarPermissao() {
        $router = \Config\Services::router(null, null, true);
        $controller = str_replace('\\App\\Controllers\\', '', $router->controllerName());
        $metodo = $router->methodName();
        $eu = ParticipanteModel::getSessao() ?? new ParticipanteEntity();
        if ($eu->verificarPermissao($controller, $metodo) !== true) {
            $url = base_url('PainelParticipante/login');
            if (ParticipanteModel::getSessao() !== null) {
                \Config\Services::session()->setFlashdata('msg_erro', 'Sem permissão para esta área!');
                $url = previous_url();
            }
            header('location: ' . $url);
            exit;
        }
    }

    /**
     * Cria um edirecionamento adicionando a variável de erro contendo a mensagem
     * passada por parâmetro 
     * 
     * @param type $erros mensagem ou lista de mensagens de erro
     * @return \CodeIgniter\HTTP\RedirectResponse 
     */
    protected function returnWithError($erros) {
        return redirect()
                        ->back()
                        ->withInput()
                        ->with('msg_erro', $erros);
    }

    /**
     * Cria redirecionamento com mensagem de sucesso
     * 
     * @param type $msg Mensagem que será enviada para destino
     * @return \CodeIgniter\HTTP\RedirectResponse 
     */
    protected function returnSucess($msg) {
        return redirect()
                        ->back()
                        ->with('msg_sucesso', $msg);
    }

    /**
     * Valida os dados do request usando as regras passadas por parâmetro
     * 
     * @param array $rules Lista de regras
     * @return array|bool retorna true se validação não gerar erro ou uma lista 
     * de erros caso a validação falhar
     */
    protected function validateWithRequest(array $rules): array|bool {
        if (count($rules) == 0){
            return true;
        }
        $v = \Config\Services::validation();
        $v->reset()->setRules($rules)->withRequest($this->request);
        if ($v->run() === true){
            return true;
        }
        return $v->getErrors();
    }

    /**
     * Retorna um nome aleatório para um determinado campo do tipo arquivo 
     * do request mantendo sua extensão
     * 
     * @param string $nameFileField Nome do campo do formulário html
     * @return string nome randômico
     */
    protected function getRandomName(string $nameFileField) {
        if ($this->request->getFile($nameFileField)?->isValid() === true) {
            return $this->request->getFile($nameFileField)->getRandomName();
        }
        return '';
    }

    protected function templateData($param) {
        
    }

}
