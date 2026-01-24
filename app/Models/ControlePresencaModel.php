<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ControlePresencaModel extends BaseModel{
    
    protected $table = 'ControlePresenca';
    protected $allowedFields = ['Evento_id', 'descricao'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Evento_id' => ['label'=> 'Evento', 'rules'=>'required|is_natural_no_zero|is_not_unique[Evento.id]'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ControlePresencaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Evento_id'])) $this->where('Evento_id =', $data['Evento_id']); 
        if(isset($data['descricao'])) $this->like('descricao', $data['descricao']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('descricao', $searchTerm);        
        return $this;
    }
    
}
