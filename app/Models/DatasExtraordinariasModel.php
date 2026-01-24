<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class DatasExtraordinariasModel extends BaseModel{
    
    protected $table = 'DatasExtraordinarias';
    protected $allowedFields = ['data', 'horaInicio', 'horaFim', 'tipo'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'data' => ['label'=> 'Data', 'rules'=>'required|valid_date[Y-m-d]'],
        'horaInicio' => ['label'=> 'Hora Início', 'rules'=>'required|horaBR'],
        'horaFim' => ['label'=> 'Hora Fim', 'rules'=>'required|horaBR'],
        'tipo' => ['label'=> 'Tipo', 'rules'=>'required|in_list[0,1]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\DatasExtraordinariasEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['horaInicio'])) $this->like('horaInicio', $data['horaInicio']);
        if(isset($data['horaFim'])) $this->like('horaFim', $data['horaFim']);
        if(isset($data['tipo'])){
            $func = is_array($data['tipo']) ? 'whereIn' : 'where';
            $this->$func('tipo', $data['tipo']);
        } 
        if(isset($data['dataStart'])) $this->where('data >=', CastDateBR::set($data['dataStart']));
        if(isset($data['dataEnd'])) $this->where('data <=', CastDateBR::set($data['dataEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('horaInicio', $searchTerm);
        $this->orLike('horaFim', $searchTerm);        
        return $this;
    }
    
}
