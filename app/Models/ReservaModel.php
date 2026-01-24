<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ReservaModel extends BaseModel{
    
    protected $table = 'Reserva';
    protected $allowedFields = ['dataCadastro', 'dataReserva', 'horaInicio', 'horaFim', 'tipo', 'numeroConvidados', 'status', 'turmaEscola', 'nomeEscola', 'anoTurma', 'horaEntrada', 'horaSaida'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'dataCadastro' => ['label'=> 'Data Cadastro', 'rules'=>'required|valid_date[Y-m-d]'],
        'dataReserva' => ['label'=> 'Data Reserva', 'rules'=>'required|valid_date[Y-m-d]'],
        'horaInicio' => ['label'=> 'Hora Início', 'rules'=>'required'],
        'horaFim' => ['label'=> 'Hora Fim', 'rules'=>'required'],
        'tipo' => ['label'=> 'Tipo', 'rules'=>'required|in_list[0,1]'],
        'numeroConvidados' => ['label'=> 'Número Convidados', 'rules'=>'required|greater_than[-1]|integer'],
        'status' => ['label'=> 'Status', 'rules'=>'required|in_list[0,1]'],
        'turmaEscola' => ['label'=> 'Turma Escola', 'rules'=>'required|in_list[0,1]'],
        'nomeEscola' => ['label'=> 'Nome Escola', 'rules'=>'permit_empty'],
        'anoTurma' => ['label'=> 'Ano Turma', 'rules'=>'permit_empty|in_list[0,1,2,3,4,5,6,7,8]'],
        'horaEntrada' => ['label'=> 'Hora Entrada', 'rules'=>'permit_empty|dataHora'],
        'horaSaida' => ['label'=> 'Hora Saída', 'rules'=>'permit_empty|dataHora'],
    ];
    protected $validationMessages = [
        'horaEntrada' => [
            'dataHora' => 'O valor {value} é inválido para o campo {field}.',
        ],
        'horaSaida' => [
            'dataHora' => 'O valor {value} é inválido para o campo {field}.',
        ],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ReservaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['horaInicio'])) $this->like('horaInicio', $data['horaInicio']);
        if(isset($data['horaFim'])) $this->like('horaFim', $data['horaFim']);
        if(isset($data['nomeEscola'])) $this->like('nomeEscola', $data['nomeEscola']);
        if(isset($data['anoTurma'])) $this->like('anoTurma', $data['anoTurma']);
        if(isset($data['horaEntrada'])) $this->like('horaEntrada', $data['horaEntrada']);
        if(isset($data['horaSaida'])) $this->like('horaSaida', $data['horaSaida']);
        if(isset($data['tipo'])){
            $func = is_array($data['tipo']) ? 'whereIn' : 'where';
            $this->$func('tipo', $data['tipo']);
        }
        if(isset($data['status'])){
            $func = is_array($data['status']) ? 'whereIn' : 'where';
            $this->$func('status', $data['status']);
        }
        if(isset($data['turmaEscola'])){
            $func = is_array($data['turmaEscola']) ? 'whereIn' : 'where';
            $this->$func('turmaEscola', $data['turmaEscola']);
        }
        if(isset($data['numeroConvidadosStart'])) $this->where('numeroConvidados >=', $data['numeroConvidadosStart']);
        if(isset($data['numeroConvidadosEnd'])) $this->where('numeroConvidados <=', $data['numeroConvidadosEnd']); 
        if(isset($data['dataCadastroStart'])) $this->where('dataCadastro >=', CastDateBR::set($data['dataCadastroStart']));
        if(isset($data['dataCadastroEnd'])) $this->where('dataCadastro <=', CastDateBR::set($data['dataCadastroEnd']));
        if(isset($data['dataReservaStart'])) $this->where('dataReserva >=', CastDateBR::set($data['dataReservaStart']));
        if(isset($data['dataReservaEnd'])) $this->where('dataReserva <=', CastDateBR::set($data['dataReservaEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('horaInicio', $searchTerm);
        $this->orLike('horaFim', $searchTerm);
        $this->orLike('nomeEscola', $searchTerm);
        $this->orLike('anoTurma', $searchTerm);
        $this->orLike('horaEntrada', $searchTerm);
        $this->orLike('horaSaida', $searchTerm);        
        return $this;
    }
    
}
