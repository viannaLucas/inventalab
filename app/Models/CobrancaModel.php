<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class CobrancaModel extends BaseModel{
    
    protected $table = 'Cobranca';
    protected $allowedFields = ['Participante_id', 'data', 'valor', 'observacoes', 'situacao'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Participante_id' => ['label'=> 'Participante', 'rules'=>'required|is_natural_no_zero|is_not_unique[Participante.id]'],
        'data' => ['label'=> 'Data', 'rules'=>'required|valid_date[Y-m-d]'],
        'valor' => ['label'=> 'Valor', 'rules'=>'required|greater_than[0]|decimal'],
        'observacoes' => ['label'=> 'Observações', 'rules'=>'required'],
        'situacao' => ['label'=> 'Situação', 'rules'=>'required|in_list[0,1,2]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\CobrancaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Participante_id'])) $this->where('Participante_id =', $data['Participante_id']); 
        if(isset($data['situacao'])){
            $func = is_array($data['situacao']) ? 'whereIn' : 'where';
            $this->$func('situacao', $data['situacao']);
        } 
        if(isset($data['valorStart'])) $this->where('valor >=', CastCurrencyBR::set($data['valorStart']));
        if(isset($data['valorEnd'])) $this->where('valor <=', CastCurrencyBR::set($data['valorEnd']));
        if(isset($data['dataStart'])) $this->where('data >=', CastDateBR::set($data['dataStart']));
        if(isset($data['dataEnd'])) $this->where('data <=', CastDateBR::set($data['dataEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
