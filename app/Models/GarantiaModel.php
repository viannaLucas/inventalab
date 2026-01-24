<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class GarantiaModel extends BaseModel{
    
    protected $table = 'Garantia';
    protected $allowedFields = ['RecursoTrabalho_id', 'descricao', 'tipo', 'dataInicio', 'dataFim'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'RecursoTrabalho_id' => ['label'=> 'Recurso Trabalho', 'rules'=>'required|is_natural_no_zero|is_not_unique[RecursoTrabalho.id]'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
        'tipo' => ['label'=> 'Tipo', 'rules'=>'required|in_list[0,1,2]'],
        'dataInicio' => ['label'=> 'Data Início', 'rules'=>'required|valid_date[Y-m-d]'],
        'dataFim' => ['label'=> 'Data Fim', 'rules'=>'required|valid_date[Y-m-d]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\GarantiaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['RecursoTrabalho_id'])) $this->where('RecursoTrabalho_id =', $data['RecursoTrabalho_id']); 
        if(isset($data['descricao'])) $this->like('descricao', $data['descricao']);
        if(isset($data['tipo'])){
            $func = is_array($data['tipo']) ? 'whereIn' : 'where';
            $this->$func('tipo', $data['tipo']);
        } 
        if(isset($data['dataInicioStart'])) $this->where('dataInicio >=', CastDateBR::set($data['dataInicioStart']));
        if(isset($data['dataInicioEnd'])) $this->where('dataInicio <=', CastDateBR::set($data['dataInicioEnd']));
        if(isset($data['dataFimStart'])) $this->where('dataFim >=', CastDateBR::set($data['dataFimStart']));
        if(isset($data['dataFimEnd'])) $this->where('dataFim <=', CastDateBR::set($data['dataFimEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('descricao', $searchTerm);        
        return $this;
    }
    
}
