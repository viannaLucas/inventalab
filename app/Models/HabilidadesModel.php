<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class HabilidadesModel extends BaseModel{
    
    protected $table = 'Habilidades';
    protected $allowedFields = ['Participante_id', 'RecursoTrabalho_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Participante_id' => ['label'=> 'Participante', 'rules'=>'required|is_natural_no_zero|is_not_unique[Participante.id]'],
        'RecursoTrabalho_id' => ['label'=> 'Recurso Trabalho', 'rules'=>'required|is_natural_no_zero|is_not_unique[RecursoTrabalho.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\HabilidadesEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Participante_id'])) $this->where('Participante_id =', $data['Participante_id']); 
        if(isset($data['RecursoTrabalho_id'])) $this->where('RecursoTrabalho_id =', $data['RecursoTrabalho_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
