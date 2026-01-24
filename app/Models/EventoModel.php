<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class EventoModel extends BaseModel{
    
    protected $table = 'Evento';
    protected $allowedFields = ['Servico_id', 'nome', 'texto', 'descricao', 'imagem', 'vagasLimitadas', 'numeroVagas', 'inscricoesAbertas', 'divulgar', 'dataInicio', 'valor'];
    protected array $sanitizeHtmlFields = ['texto'];
    protected $beforeInsert = ['sanitizeHtmlFields'];
    protected $beforeUpdate = ['sanitizeHtmlFields'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'texto' => ['label'=> 'Texto', 'rules'=>'required'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
        'imagem' => ['label'=> 'Imagem', 'rules'=>'permit_empty'],
        'Servico_id' => ['label'=> 'Serviço', 'rules'=>'required|is_natural_no_zero|is_not_unique[Servico.id]'],
        'vagasLimitadas' => ['label'=> 'Vagas Limitadas', 'rules'=>'required|in_list[0,1]'],
        'numeroVagas' => ['label'=> 'Número Vagas', 'rules'=>'permit_empty|integer'],
        'inscricoesAbertas' => ['label'=> 'Inscrições Abertas', 'rules'=>'required|in_list[0,1]'],
        'divulgar' => ['label'=> 'Divulgar', 'rules'=>'required|in_list[0,1]'],
        'dataInicio' => ['label'=> 'Data Início', 'rules'=>'required|valid_date[Y-m-d]'],
        'valor' => ['label'=> 'Valor', 'rules'=>'permit_empty|decimal|greater_than_equal_to[0]'],
    ];
    protected $validationRulesFiles = [
        'imagem' => ['label'=> 'Imagem', 'rules'=>'is_image[imagem]|max_size[imagem,10240]|ext_in[imagem,jpg,jpeg,webp,png]'],
    ];
    protected $returnType = \App\Entities\EventoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['nome'])) $this->like('nome', $data['nome']);
        if(isset($data['vagasLimitadas'])){
            $func = is_array($data['vagasLimitadas']) ? 'whereIn' : 'where';
            $this->$func('vagasLimitadas', $data['vagasLimitadas']);
        }
        if(isset($data['inscricoesAbertas'])){
            $func = is_array($data['inscricoesAbertas']) ? 'whereIn' : 'where';
            $this->$func('inscricoesAbertas', $data['inscricoesAbertas']);
        }
        if(isset($data['divulgar'])){
            $func = is_array($data['divulgar']) ? 'whereIn' : 'where';
            $this->$func('divulgar', $data['divulgar']);
        }
        if(isset($data['numeroVagasStart'])) $this->where('numeroVagas >=', $data['numeroVagasStart']);
        if(isset($data['numeroVagasEnd'])) $this->where('numeroVagas <=', $data['numeroVagasEnd']); 
        if(isset($data['dataInicioStart'])) $this->where('dataInicio >=', CastDateBR::set($data['dataInicioStart']));
        if(isset($data['dataInicioEnd'])) $this->where('dataInicio <=', CastDateBR::set($data['dataInicioEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);        
        return $this;
    }
    
}
