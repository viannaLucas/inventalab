<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class TabelaFKModel extends BaseModel{
    
    protected $table = 'TabelaFK';
    protected $allowedFields = ['nome'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\TabelaFKEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['nome'])) $this->like('nome', $data['nome']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);        
        return $this;
    }
    
}
