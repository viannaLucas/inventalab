<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;
use App\Entities\ParticipanteEntity;
use App\Libraries\SescAPI;

class ParticipanteModel extends BaseModel{
    
    private const SESSION_NAME = 'sessao_participante_maker';

    protected $table = 'Participante';
    protected $allowedFields = ['nome', 'telefone', 'email', 'cpf', 'logradouro', 'numero', 'bairro', 'cidade', 'codigoCidade', 'uf', 'cep', 'nomeResponsavel', 'dataNascimento', 'termoResponsabilidade', 'suspenso', 'observacoesGerais', 'senha', 'codigoApiSesc'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'telefone' => ['label'=> 'Telefone', 'rules'=>'required|telefone'],
        'email' => ['label'=> 'Email', 'rules'=>'required|valid_email|is_unique[Participante.email,id,{id}]'],
        'cpf' => ['label'=> 'CPF', 'rules'=>'required|cpf|max_length[20]'],
        'logradouro' => ['label'=> 'Logradouro', 'rules'=>'required|max_length[200]'],
        'numero' => ['label'=> 'Número', 'rules'=>'permit_empty|integer|max_length[20]'],
        'bairro' => ['label'=> 'Bairro', 'rules'=>'required|max_length[100]'],
        'cidade' => ['label'=> 'Cidade', 'rules'=>'required|max_length[100]'],
        'codigoCidade' => ['label'=> 'Código Cidade', 'rules'=>'permit_empty|regex_match[/^\\d+$/]'],
        'uf' => ['label'=> 'UF', 'rules'=>'required|in_list[AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO]'],
        'cep' => ['label'=> 'CEP', 'rules'=>'required|cep|max_length[10]'],
        'nomeResponsavel' => ['label'=> 'Nome do Responsável', 'rules'=>'permit_empty|max_length[100]'],
        'dataNascimento' => ['label'=> 'Data Nascimento', 'rules'=>'required|valid_date[Y-m-d]'],
        // 'termoResponsabilidade' => ['label'=> 'Termo Responsabilidade', 'rules'=>'required'],
        'suspenso' => ['label'=> 'Suspenso', 'rules'=>'required|in_list[0,1]'],
        'observacoesGerais' => ['label'=> 'Observações Gerais', 'rules'=>'permit_empty'],
        'senha' => ['label'=> 'Senha', 'rules'=>'required|senhaForte'],
        'codigoApiSesc' => ['label'=> 'Código API Sesc', 'rules'=>'permit_empty|max_length[30]|alpha_numeric'],
    ];
    protected $validationRulesFiles = [
        'termoResponsabilidade' => ['label'=> 'Termo Responsabilidade', 'rules'=>'permit_empty|ext_in[termoResponsabilidade,doc,docx,pdf,xls,xlsx,csv,png,jpg,jpeg,gif,webp]|max_size[termoResponsabilidade,20480]'],
        'senha' => ['label'=> 'Senha', 'rules'=>'permit_empty|senhaForte'],
        'confirmaSenha' => ['label'=> 'Confirmação Senha', 'rules'=>'permit_empty|matches[senha]'],
    ];
    protected $returnType = \App\Entities\ParticipanteEntity::class;
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Já existe um Participante cadastrado com este email.',
            'valid_email' => 'Informe um endereço de email válido.',
            'required' => 'O campo {field} é obrigatório.',
        ],
        'senha' => [
            'senhaForte' => 'A senha deve ter no mínimo 6 caracteres, com ao menos 1 letra maiúscula, 1 letra minúscula e 1 número.',
        ],
    ];

    protected $beforeUpdate = ['bloquearAlteracaoEmail'];
    //remove o email dos dados da alteração
    protected function bloquearAlteracaoEmail(array $data)
    {
        if (isset($data['data']['email'])) {
            unset($data['data']['email']); // remove o campo da atualização
        }
        return $data;
    }

    /**
     * Faz pesquisa com conjuntos de dados e intervalo de valores no caso de 
     * números e datas adicionando sufixo 'Start' e 'End' no nome do campo
     * 
     * Ex.: Campo Pedido->dataCadastro => $data['dataCadastroStart'] 
     * e $data['dataCadastroStart'] podem ser usados para definir um intervalo
     * 
     * @param array $data
     * @return $this
     */
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->getCompiledSelect(); //clear builder
        if(isset($data['nome'])) $this->like('nome', $data['nome']);
        if(isset($data['email'])) $this->like('descricao', $data['email']);
        if(isset($data['cpf'])) $this->like('cpf', $data['cpf']);
        if(isset($data['cidade'])) $this->like('cidade', $data['cidade']);
        if(isset($data['cep'])) $this->like('cep', $data['cep']);
        if(isset($data['suspenso'])){
            $func = is_array($data['suspenso']) ? 'whereIn' : 'where';
            $this->$func('suspenso', $data['suspenso']);
        }
        return $this;
    }
    
    /**
     * Faz um busca ampla usando um termo de pesquisa
     * 
     * @param string $searchTerm
     * @return $this
     */
    public function buildFindModal(string $searchTerm){
        $this->builder()->getCompiledSelect(); //clear builder
        $this->groupStart();
        $this->orLike('nome', $searchTerm);
        $this->orLike('email', $searchTerm);
        $this->orLike('cpf', $searchTerm);
        $this->orLike('cidade', $searchTerm);
        $this->orLike('cep', $searchTerm);
        $this->groupEnd();
        $this->where('suspenso', ParticipanteEntity::SUSPENSO_NAO);
        return $this;
    }
    
    /**
     * Verifica se há usuário com o login e senha informados, caso exista salva 
     * na sessão
     * 
     * @param string $login Login do usuário
     * @param string $planPW senha do usuário em texto puro
     * @return bool Retorna true caso exista um usuário com o login e senha informado
     */
    public function login($login, $planPW):bool {
        $u = new ParticipanteModel();
        if ($login != "" && $planPW != ''){
            $eu = $u->where('email', $login)->first();
            if($eu instanceof \App\Entities\ParticipanteEntity 
                    && password_verify($planPW, $eu->senha)
                    // && $eu->suspenso == ParticipanteEntity::SUSPENSO_NAO
                    ){
                $encrypter = \Config\Services::encrypter();
                session()->set(self::SESSION_NAME, $encrypter->encrypt($eu->id));
                return true;
            }
        }
        return false;
    }

    /**
     * Remove usuário da sessão
     * 
     * @return bool true se removido, caso contrário false
     */
    public static function logout():bool{
        $session = session();
        $session->removeTempdata('ptemp');
        $session->remove(self::SESSION_NAME);
        return !$session->has(self::SESSION_NAME);
    }

    /**
     * Busca usuário da sessão, não use este retorno para alterar os dados do 
     * usuário devido o filtro de senha usado para não guardar esta informação
     * na sessão
     * 
     * @return ParticipanteEntity|null Retorna o usuário da sessão, se não tiver retorna null
     */
    public static function getSessao():\App\Entities\ParticipanteEntity|null {
        $return = null;
        if(session(self::SESSION_NAME) !== null){
            $ptemp = session()->getTempdata('ptemp');
            if($ptemp == null){
                $encrypter = \Config\Services::encrypter();
                $id = $encrypter->decrypt(session(self::SESSION_NAME));
                $m = new ParticipanteModel();
                $ue = $m->find($id);
                if($ue == null || $ue->suspenso == ParticipanteEntity::SUSPENSO_SIM) {
                    ParticipanteModel::logout();
                    return null;
                }
                $vc = $ue->toArray();
                $vc['senha'] = '';
                $ptemp = new ParticipanteEntity($vc);
                session()->setTempdata('ptemp',$ptemp,1);
            }
            return $ptemp;
        }        
        return $return;
    }
    
    public function cadastroSescApi(ParticipanteEntity $participante) : string
    {
        $sescApi = new SescAPI([
            'baseUrl'=> env('sescApi_baseUrl'),
            'username'=> env('sescApi_username'),
            'password'=> env('sescApi_password'),
            'environment'=> env('sescApi_environment'),
            'timeout_seconds'=> env('sescApi_timeoutSeconds'),
        ]);
        $consultaSesc = $sescApi->consultaCliente($participante->cpf);
        
        if(isset($consultaSesc['decoded_response']['Data']['InterfaceDoCliente'][0]['Codigo'])){
            return $consultaSesc['decoded_response']['Data']['InterfaceDoCliente'][0]['Codigo'];
        } else {
            $codigo = preg_replace('/\\D+/', '', date('mdHis')) ?? date('mdHis');
            $codigo = substr($codigo, 0, 15);
            $dados = [
                "SequenciadoRegistro" => 1,
                "Codigo" => $codigo,
                "TipodePessoa" => "F",
                "NomeFantansia" => $participante->nomeResponsavel != '' ? $participante->nomeResponsavel : $participante->nome,
                "Nome" => $participante->nomeResponsavel != '' ? $participante->nomeResponsavel : $participante->nome,
                "CPFouCNPJ" => $participante->cpf,
                "TipodoLocaldoIndicadordeInscricaoEstadual" => env('sescApi_TipodoLocaldoIndicadordeInscricaoEstadual'),
                "Inscricao" => "",
                "Email" => $participante->email,
                "Telefone" => $participante->telefone,
                "Endereco" => $participante->logradouro,
                "NumerodoEndereco" => $participante->numero,
                "Bairro" => $participante->bairro,
                "Cidade" => $participante->cidade,
                "Uf" => $participante->uf,
                "Cep" => $participante->cep,
                "CodigodoPais" => "BRA",
                "CodigodaCidade" => $participante->codigoCidade,
                "Pais" => "Brasil",
                "Ativo" => "A"
            ];
            $respCadastroSesc = $sescApi->cadastroCliente($dados);

            if($respCadastroSesc['decoded_response']['Success'] == true
                    && $respCadastroSesc['decoded_response']['Data'] != null){
                return $respCadastroSesc['decoded_response']['Data'];
            }
            return '';
        }
    }
}
